<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Page;
use Alice\Repositories\PagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Alice\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class PageController extends AdminController
{
    public function __construct(PagesRepository $page) {
        parent::__construct();
        $this->pageRep = $page;
        $this->template = env('THEME').'.admin.page';
    }

    /**
     * Display a listing of the resource.
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер страниц';
        $this->title_h = $this->title;
        $pages = Page::all();

        $this->content = view(env('THEME').'.admin.layouts.pageContent')->with('pages', $pages)->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавление страницы';
        $this->title_h = $this->title;

        $this->content = view(env('THEME').'.admin.layouts.pageCreate')->render();
        return $this->renderOutput();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/page/create')->with($result);
        }
        return redirect('/admin/page')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $page
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $page = $this->getPageByAlias($alias)->first();
        $this->title = 'Редактировании страницы';
        $this->title_h = $this->title . ' - <span>'. $page->title . '</span>';

        $this->content = view(env('THEME').'.admin.layouts.pageCreate')->with('page', $page)->render();
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $alias
     * @return $this
     */
    public function update(Request $request, $alias){
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), $alias);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/page/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/page')->with($result);
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return $this
     */
    public function destroy($alias){
        $result = $this->pageRep->deletePageByAlias($alias);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/page')->with($result);
        }
        return redirect('/admin/page')->with($result);
    }


    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $alias
     * @return array
     */
    public function validator($request, $rules, $alias){

        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->pageRep->actionPage($request, $alias);
        }
    }

    /**
     * Delete by id from storage
     * @param $alias
     * @return bool
     */
    public function getPageByAlias($alias){
        $page = $this->pageRep->get('*', false, false, [['alias', $alias]], false);
        return $page;
    }

}
