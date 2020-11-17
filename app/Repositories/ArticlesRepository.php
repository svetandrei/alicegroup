<?php

namespace Alice\Repositories;

use Alice\Article;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ArticlesRepository extends Repository {
    public function __construct(Article $articles) {
        $this->model = $articles;
    }

    /**
     * All action for storage of table
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionArticle($request, $alias){
        $route = $request->capture()->segments();
        $article = '';
        if ($alias){
            $article = Article::where('alias', $alias)->first();
        }

        $data = $request->except('_token', 'file');

//        $collection = collect($data);
//        $data = $collection->filter(function ($value, $key) {
//            return $value !== null;
//        })->toArray();

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        $data['alias'] = $this->transliterate($data['title']);

        $result = $this->one($data['alias'],false);

        if(isset($result->id) && ($alias == false)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется.'];
        } else {
            if (isset($result->id) && ($result->id != $article->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if($request->hasFile('file')) {
            $data['image'] = $this->checkFile($request->file('file'), true, $route, 'thumbnail');
        }

        if ($alias){
            $article->fill($data);
            if($article->update()) {
                return ['status' => 'Материал обновлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            $this->model->fill($data);
            if($this->model->save()) {
                return ['status' => 'Материал добавлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }

    /**
     * Delete material of storage
     * @param $alias
     * @return array
     */
    public function deleteArticleByAlias($alias){
        $article = Article::where('alias', $alias)->first();

        if($article->delete()) {
            return ['status' => 'Материал '.$article->title.' удален', 'class' => 'alert-success'];
        }
    }
}

?>