<?php

namespace Alice\Repositories;

use Alice\Menu;

class MenuRepository extends Repository {
    public function __construct(Menu $menu) {
        $this->model = $menu;
    }

    /**
     * Update and add item menu to storage
     * @param $request
     * @param $menu
     * @return array
     */
    public function actionMenu($request, $id) {

        $menu = '';
        if ($id){
            $menu = Menu::where('id', $id)->first();
        }
        $data = $request->except('_token','_method');

//        $collection = collect($data);
//        $data = $collection->filter(function ($value, $key) {
//            return $value !== null;
//        })->toArray();

        if(empty($data)) {
            return ['error'=>'Нет данных'];
        }

        switch($data['type']) {
            case 'pageLink':
                if($request->input('page-alias')) {
                    $data['url'] = route('page', ['page' => $request->input('page-alias')]);
                }
                break;
            case 'infoLink' :
                if($request->input('category-alias')) {
                    if($request->input('category-alias') == 'parent') {
                        $data['url'] = route('category');
                    }
                    else {
                        $data['url'] = route('category', ['category' => $request->input('category-alias')]);
                    }
                }
                break;
            case 'serviceLink' :
                if($request->input('category-service')) {
                    $data['url'] = route('services');
                }
                else if($request->input('service-alias')) {
                    $data['url'] = route('service', ['service' => $request->input('service-alias')]);
                }
                break;
            case 'galleryLink' :
                if($request->input('category-gallery')) {
                    $data['url'] = route('portfolio');
                }
                break;

        }
        unset($data['type']);

        if ($id){
            if($menu->fill($data)->update()) {
                return ['status' => 'Ссылка обновлена', 'class' => 'alert-success'];
            }
        } else {
            if($this->model->fill($data)->save()) {
                return ['status' => 'Ссылка добавлена', 'class' => 'alert-success'];
            }
        }
    }

    /**
     * @param $menu
     * @return array
     */
    public function deleteMenuByID($id) {
        $menu = Menu::where('id', $id);
        if($menu->delete()) {
            return ['status'=> 'Ссылка удалена', 'class' => 'alert-success'];
        }
    }
}

?>