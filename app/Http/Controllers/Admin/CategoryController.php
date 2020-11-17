<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Category;
use Alice\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Alice\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class CategoryController extends AdminController {


    public function __construct(CategoryRepository $category) {
        parent::__construct();
        $this->catRep = $category;
        $this->template = env('THEME').'.admin.category';
    }

    /**
     * Display a listing of the resource.
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер категории';
        $this->title_h = $this->title;
        $categories = Category::all();

        $this->content = view(env('THEME').'.admin.layouts.categoryContent')->with('categories', $categories)->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавление категории';
        $this->title_h = $this->title;
        $categories = $this->getCategoryByAlias(false);
        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat->parent_id][$cat->id] = $cat;
        }
        $cats = $this->buildTree($arCategory, 0, 1, false, false);

        $this->content = view(env('THEME').'.admin.layouts.categoryCreate')->with('categories', $cats)->render();
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
            'file' => 'required|image'
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/category/create')->with($result);
        }
        return redirect('/admin/category')->with($result);
    }

    /**
     * Display the specified resource.
     * @param $id
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $category = $this->getCategoryByAlias($alias)->first();
        $this->title = 'Редактировании категории';
        $this->title_h = $this->title . ' - <span>'. $category->title . '</span>';

        $categories = $this->getCategoryByAlias(false);

        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat['parent_id']][$cat['id']] = $cat;
        }

        $cats = $this->buildTree($arCategory, 0, 1, $category->parent_id, $category->id);
        $this->content = view(env('THEME').'.admin.layouts.categoryCreate')->with('category', $category)->with('categories', $cats)->render();
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
            'file' => 'image'
        ), $alias);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/category/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/category')->with($result);
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return $this
     */
    public function destroy($alias){
        $result = $this->catRep->deleteCategoryByAlias($alias);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/category')->with($result);
        }
        return redirect('/admin/category')->with($result);
    }

    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $id
     * @return array
     */
    public function validator($request, $rules, $id){

        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->catRep->actionCategory($request, $id);
        }
    }


    /**
     * Template for output of category in the form of a tree
     * @param $cats
     * @param $parentID
     * @param int $level
     * @param bool $selectID
     * @return null|string
     */
    public function buildTree($cats, $parentID, $level = 1, $selectID = false, $currID = false){
        if(is_array($cats) and isset($cats[$parentID])){
            $tree = '';
            $str = '';
            foreach($cats[$parentID] as $key => $cat) {
                if ($parentID > 0){
                    $level = $level + 1;
                    if ($level > 2) {
                        $strLevel = $level * 2.5;
                    } else {$strLevel = $level * 2;}
                    for ($i = 0; $i < $strLevel; $i++){
                        $arStr[] = '.';
                    }
                    $str = implode('', $arStr);
                } else {
                    $level = 1;
                }
                $tree .= '<option value="'.$cat->id.'" '.($selectID == $cat->id?'selected':'').' '.($currID == $cat->id ? 'disabled':'').'>'. $str . $cat->title ;
                $tree .= $this->buildTree($cats, $cat->id, $level, $selectID, $currID);
                $tree .= '</option>';
                $level = 1;
                $str = '';
                $arStr = array();
            }
        }
        else return null;
        return $tree;
    }

    /**
     * Get categories by alias from storage
     * @param $alias
     * @return bool
     */
    public function getCategoryByAlias($alias){
        if ($alias){
            $res = $this->catRep->get('*',false, false, [['alias', $alias]], ['updated_at', 'DESC']);
        } else {
            $res = $this->catRep->get('*',false, false, false, ['updated_at', 'DESC']);
        }
        return $res;
    }


}
