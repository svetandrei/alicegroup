<?php

namespace Alice\Repositories;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

abstract class Repository {
    protected $model = false;

    public function get($select = '*',$take = false, $pagination = false, $where = false, $order = false) {

        $builder = $this->model->select($select);

        if($take) {
            $builder->take($take);
        }

        if ($where){
            $builder->where($where);
        }
        if ($order){
            $builder->orderBy($order[0], $order[1]);
        }

        if($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    /**
     * Check builder
     * @param $result
     * @return bool
     */
    protected function check($result) {

        if($result->isEmpty()) {
            return false;
        }

        $result->transform(function($item, $key) {

            if(is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }

            return $item;

        });

        return $result;

    }

    /**
     * Check alias
     * @param $alias
     * @param array $attr
     * @return mixed
     */
    public function one($alias, $attr = array()) {
        $result = $this->model->where('alias', $alias)->first();
        return $result;
    }

    /**
     * Transliterate alias cyrillic to latin
     * @param $string
     * @return bool|mixed|null|string|string[]
     */
    public function transliterate($string) {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = array(
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г,ґ',
            'd' => 'д',
            'e' => 'е,є,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и,і',
            'ji' => 'ї',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        );

        foreach($leter_array as $leter => $kyr) {
            $kyr = explode(',',$kyr);
            $str = str_replace($kyr, $leter, $str);
        }

        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','-',$str);
        $str = trim($str,'-');

        return $str;
    }

    /**
     * Check file and save to path
     * @param $file
     * @param $resize
     * @return string
     */
    public function checkFile($file, $resize, $route = '', $size = 'thumbnail'){
        if($file->isValid()) {
            $ext = $file->getClientOriginalExtension();

            $obj = new \stdClass;
            $str = Carbon::now()->format('Ymd_').rand(0, 5000);
            $obj->image = $str.'_thumb.'.$ext;
            $modFile = '';
            if ($resize) {
                $img = Image::make($file);
                $modFile = $img->fit(Config::get('image.'.$size.'_'.$route[1])['width'],
                    Config::get('image.'.$size.'_'.$route[1])['height'])->encode($ext);
            } else {
                $modFile = Image::make($file)->encode($ext);
            }
            Storage::disk('public')->put($obj->image, $modFile);

            return $obj->image;
        }
    }

}

?>