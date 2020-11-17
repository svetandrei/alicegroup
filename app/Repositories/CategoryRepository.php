<?php

namespace Alice\Repositories;

use Alice\Category;

class CategoryRepository extends Repository {
    public function __construct(Category $cats) {
        $this->model = $cats;
    }

    /**
     * Save and update material to storage
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionCategory($request, $alias){
        $route = $request->capture()->segments();
        $category = '';
        if ($alias){
            $category = Category::where('alias', $alias)->first();
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
            if (isset($result->id) && ($result->id != $category->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if($request->hasFile('file')) {
            $data['image'] = $this->checkFile($request->file('file'), true, $route, 'thumbnail');
        }

        if ($alias){
            $category->fill($data);
            if($category->update()) {
                return ['status' => 'Категория обновлена', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            if(Category::create($data)) {
                return ['status' => 'Категория добавлена', 'class' => 'alert-success'];
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
    public function deleteCategoryByAlias($alias){
        $category = Category::where('alias', $alias)->first();

        if($category->delete()) {
            return ['status' => 'Категория '.$category->title.' удалена', 'class' => 'alert-success'];
        }
    }
}

?>