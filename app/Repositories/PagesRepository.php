<?php

namespace Alice\Repositories;

use Alice\Page;

class PagesRepository extends Repository {
    public function __construct(Page $page) {
        $this->model = $page;
    }

    /**
     * Save and update material to storage
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionPage($request, $alias){
        $page = '';
        if ($alias){
            $page = Page::where('alias', $alias)->first();
        }

        $data = $request->except('_token');

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
            if (isset($result->id) && ($result->id != $page->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if ($alias){
            $page->fill($data);
            if($page->update()) {
                return ['status' => 'Материал обновлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            if(Page::create($data)) {
                return ['status' => 'Материал добавлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }

    /**
     * Delete by id from storage
     * @param $alias
     * @return array
     */
    public function deletePageByAlias($alias){
        $page = Page::where('alias', $alias)->first();

        if($page->delete()) {
            return ['status' => 'Страница '.$page->title.' удалена', 'class' => 'alert-success'];
        }
    }
}

?>