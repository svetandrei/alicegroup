<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Article;
use Alice\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use Alice\Http\Requests\StoreAdminRequest;
use Alice\Http\Controllers\Controller;
use Alice\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class ArticlesController extends AdminController {

    public function __construct(ArticlesRepository $article) {
        parent::__construct();
        $this->articlesRep = $article;

        $this->template = env('THEME').'.admin.articles';
    }

    /**
     * Output all materials
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер информации';
        $this->title_h = $this->title;

        $articles = $this->getArticlesByAlias(false);

        $this->content = view(env('THEME').'.admin.layouts.articlesContent')->with('articles', $articles)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новую информацию';
        $this->title_h = $this->title;

        $categories = Category::select(['id', 'parent_id', 'title', 'alias'])->get();
        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat->parent_id][$cat->id] = $cat;
        }
        $cats = $this->buildTree($arCategory,0, 1,false);

        $this->content = view(env('THEME').'.admin.layouts.articleCreate')->with('categories', $cats)->render();
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
            'file' => 'required|image',
            'category_id' => 'required|integer'
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/informations/create')->with($result);
        }
        return redirect('/admin/informations')->with($result);
    }

    /**
     * Edit of material
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $article = $this->getArticlesByAlias($alias)->first();

        $this->title = 'Редактирование информации - '. $article->title;
        $this->title_h = 'Редактирование информации - <span>'. $article->title . '</span>';
        $categories = Category::select(['id', 'parent_id', 'title', 'alias'])->get();
        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat->parent_id][$cat->id] = $cat;
        }

        $cats = $this->buildTree($arCategory,0, 1, $article->category_id);

        $this->content = view(env('THEME').'.admin.layouts.articleCreate')->with('article', $article)->with('categories', $cats)->render();
        return $this->renderOutput();
    }

    /**
     * Update material
     * @param Request $request
     * @param $alias
     * @return $this
     */
    public function update(Request $request, $alias)
    {
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
            'file' => 'image',
            'category_id' => 'required|integer'
        ), $alias);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/informations/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/informations')->with($result);
    }

    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $alias
     * @return array
     */
    public function validator($request, $rules, $alias){
        $result = array();
        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->articlesRep->actionArticle($request, $alias);
        }
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return $this
     */
    public function destroy($alias){
        $result = $this->articlesRep->deleteArticleByAlias($alias);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/informations')->with($result);
        }
        return redirect('/admin/informations')->with($result);
    }

    /**
     * Template for output of category in the form of a tree
     * @param $cats
     * @param $parentID
     * @param int $level
     * @param bool $selectID
     * @return null|string
     */
    public function buildTree($cats, $parentID, $level = 1, $selectID = false){
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
                $tree .= '<option value="'.$cat->id.'" '.($selectID == $cat->id?'selected':'').'>'. $str . $cat->title ;
                $tree .= $this->buildTree($cats, $cat->id, $level, $selectID);
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
     * Get data of articles
     * @return bool
     */
    public function getArticlesByAlias($alias){
        if ($alias){
            $res = $this->articlesRep->get('*',false, false, [['alias', $alias]], ['updated_at','DESC']);
        } else {
            $res = $this->articlesRep->get('*',false, false, false, ['updated_at','DESC']);
        }
        return $res;
    }

}
