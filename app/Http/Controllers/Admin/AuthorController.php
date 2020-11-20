<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Announcement;
use Alice\Author;
use Alice\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class AuthorController extends AdminController
{
    public function __construct() {
        parent::__construct();
        $this->template = env('THEME').'.admin.author';
    }

    /**
     * Output all accordion
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер авторов';
        $this->title_h = $this->title;
        $authors = Author::all();
        $this->content = view(env('THEME').'.admin.layouts.authorContent')
            ->with('authors', $authors)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новый автор';
        $this->title_h = $this->title;

        $this->content = view(env('THEME').'.admin.layouts.authorCreate')->render();
        return $this->renderOutput();
    }

    /**
     * Create material
     * @param Request $request
     * @return $this
     */
    public function store(Request $request){

        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/author/create')->with($result);
        }
        return redirect('/admin/author')->with($result);
    }

    /**
     * Edit material by id
     * @param $id
     * @return $this
     * @throws \Throwable
     */
    public function edit($id){
        $author = Author::where('id', $id)->first();

        $this->title = 'Редактирование автора - '. $author->title;
        $this->title_h = 'Редактирование автора - <span>'. $author->title . '</span>';

        $this->content = view(env('THEME').'.admin.layouts.authorCreate')->with('author', $author)->render();
        return $this->renderOutput();
    }

    /**
     * Update material by id
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function update(Request $request, $id) {
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), $id);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/author/'.$id.'/edit')->with($result);
        }
        return redirect('/admin/author')->with($result);
    }

    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $id
     * @return array
     */
    public function validator($request, $rules, $id){
        $result = array();
        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->actionAuthor($request, $id);
        }
    }

    /**
     * Delete material from storage
     * @param $id
     * @return $this
     */
    public function destroy($id){
        $result = $this->deleteAuthorByID($id);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/author')->with($result);
        }
        return redirect('/admin/author')->with($result);
    }

    /**
     * Save and update material to storage
     * @param $request
     * @param $id
     * @return array
     */
    public function actionAuthor($request, $id){
        $route = $request->capture()->segments();
        $accordion = '';
        if ($id){
            $accordion = Author::where('id', $id)->first();
        }

        $data = $request->except('_token');

        $collection = collect($data);
        $data = $collection->filter(function ($value, $key) {
            return $value !== null;
        })->toArray();

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if ($id){
            $accordion->fill($data);
            if($accordion->update()) {
                return ['status' => 'Материал обновлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            if(Author::create($data)) {
                return ['status' => 'Материал добавлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }

    /**
     * Delete by id from storage
     * @param $id
     * @return array
     */
    public function deleteAuthorByID($id){
        $accordion = Author::where('id', $id)->first();

        if($accordion->delete()) {
            return ['status' => 'Материал '.$accordion->title.' удален', 'class' => 'alert-success'];
        }
    }
}
