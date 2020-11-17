<?php

namespace Alice\Repositories;

use Alice\Service;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ServicesRepository extends Repository {
    public function __construct(Service $service) {
        $this->model = $service;
    }

    /**
     * Save and update material in storage
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionService($request, $alias){
        $route = $request->capture()->segments();
        $service = '';
        if ($alias){
            $service = Service::where('alias', $alias)->first();
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
            if (isset($result->id) && ($result->id != $service->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if ($request->hasFile('file')) {
            $data['image'] = $this->checkFile($request->file('file'), true, $route, 'thumbnail');
        }
        if ($request->hasFile('files')){
            $images = array();
            foreach ($request->file('files') as $image) {
                $images[] = $this->checkFile($image, true, $route, 'gallery');
            }
            $data['images'] = json_encode($images);
        }

        if ($alias){
            $service->fill($data);
            if($service->update()) {
                return ['status' => 'Услуга обновлена', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            $this->model->fill($data);
            if($this->model->save()) {
                return ['status' => 'Услуга добавлена', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }

    /**
     *
     * Delete material of storage
     * @param $alias
     * @return array
     */
    public function deleteServiceByAlias($alias){
        $service = Service::where('alias', $alias)->first();

        if($service->delete()) {
            return ['status' => 'Материал '.$service->title.' удален', 'class' => 'alert-success'];
        }
    }
}
