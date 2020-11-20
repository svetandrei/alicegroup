<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Category;
use Alice\Article;
use Alice\Portfolio;
use Alice\Repositories\ArticlesRepository;
use Alice\Repositories\CategoryRepository;
use Alice\Repositories\DefaultRepository;
use Alice\Repositories\MenuRepository;
use Alice\Repositories\PagesRepository;
use Alice\Repositories\PortfolioRepository;
use Alice\Repositories\ServicesRepository;
use Alice\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Alice\Http\Controllers\Controller;
use Menu;

class MenuController extends AdminController
{
    protected $stockRep;
    public function __construct(MenuRepository $menu,
                                ServicesRepository $service,
                                PortfolioRepository $gallery,
                                ArticlesRepository $article,
                                CategoryRepository $category,
                                PagesRepository $page) {
        parent::__construct();

        $this->menuRep = $menu;
        $this->galleryRep = $gallery;
        $this->articlesRep = $article;
        $this->servicesRep = $service;
        $this->catRep = $category;
        $this->pageRep = $page;
        $this->stockRep = new DefaultRepository(new Stock());

        $this->template = env('THEME').'.admin.menu';
    }

    /**
     * Display a listing of the resource.
     * @return $this
     * @throws \Throwable
     */
    public function index() {
        $this->title = 'Менеджер меню';
        $this->title_h = $this->title;
        $menus = $this->getDataOfMenu();

        $this->content = view(env('THEME').'.admin.layouts.menuContent')->with('menus', $menus)->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     * @return $this
     * @throws \Throwable
     */
    public function create() {
        $this->title = 'Добавление пункта меню';
        $this->title_h = $this->title;

        $tmp = $this->getDataOfMenu();

        $menus = $tmp->reduce(function($returnMenus, $menu) {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },['0' => 'Родительский пункт меню']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat['parent_id']][$cat['id']] = $cat;
        }

        $cats = $this->buildTree($arCategory, 0, 1, false, false);

        $pages = $this->pageRep->get(['id', 'title', 'alias']);
        $pages = $pages->reduce(function ($returnPages, $page) {
            $returnPages[$page->alias] = $page->title;
            return $returnPages;
        }, []);

        $articles = $this->articlesRep->get(['id','title','alias']);
        $articles = $articles->reduce(function ($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $services = $this->servicesRep->get(['id','title','alias']);
        $services = $services->reduce(function ($returnServices, $service) {
            $returnServices[$service->alias] = $service->title;
            return $returnServices;
        }, []);

        $stocks = $this->stockRep->get(['id','title','alias']);
        $stocks = $stocks->reduce(function ($returnStocks, $stock) {
            $returnStocks[$stock->alias] = $stock->title;
            return $returnStocks;
        }, []);

        $portfolios = $this->galleryRep->get(['id','image'])->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->id] = $portfolio->image;
            return $returnPortfolios;
        }, []);

        $this->content = view(env('THEME').'.admin.layouts.menuCreate')
            ->with(['menus' => $menus, 'categories' => $cats, 'articles' => $articles, 'portfolios' => $portfolios, 'services' => $services, 'pages' => $pages, 'stocks' => $stocks])->render();
        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/menu/create')->with($result);
        }
        return redirect('/admin/menu')->with($result);
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
     * @param $id
     * @return $this
     * @throws \Throwable
     */
    public function edit($id) {

        $menu = $this->getMenuByID($id);

        $this->title = 'Редактирование пункта меню';
        $this->title_h = $this->title.' - <span>'.$menu->title.'</span>';

        $type = false;
        $option = false;
        $check = array();

        //path
        $route = app('router')->getRoutes()->match(app('request')->create($menu->url));

        $aliasRoute = $route->getName();
        $parameters = $route->parameters();

        if($aliasRoute == 'page') {
            $type = 'pageLink';
            $option = isset($parameters['page']) ? $parameters['page'] : '';
        }

        else if($aliasRoute == 'category') {
            $type = 'infoLink';
            $option = isset($parameters['category']) ? $parameters['category'] : 'parent';

        }

        else if($aliasRoute == 'services') {
            $type = 'serviceLink';
            $option = 'services';
            $check['service'] = true;

        }

        else if($aliasRoute == 'services.show') {
            $type = 'serviceLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';

        }else if($aliasRoute == 'portfolio') {
            $type = 'galleryLink';
            $check['gallery'] = true;
        }else if($aliasRoute == 'stocks') {
            $type = 'stockLink';
            $option = 'stock';
            $check['stock'] = true;

        }else if($aliasRoute == 'stock.show') {
            $type = 'stockLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';

        }


        $tmp = $this->getNav()->all();

        $menus = $tmp->reduce(function($returnMenus, $menu) {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },['0' => 'Родительский пункт меню']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        $arCategory = array();
        foreach($categories as $cat){
            $arCategory[$cat['parent_id']][$cat['id']] = $cat;
        }

        $cats = $this->buildTree($arCategory, 0, 1, $option, false);

        $pages = $this->pageRep->get(['id', 'title', 'alias']);
        $pages = $pages->reduce(function ($returnPages, $page) {
            $returnPages[$page->alias] = $page->title;
            return $returnPages;
        }, []);

        $articles = $this->articlesRep->get(['id','title','alias']);
        $articles = $articles->reduce(function ($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $services = $this->servicesRep->get(['id','title','alias']);
        $services = $services->reduce(function ($returnServices, $service) {
            $returnServices[$service->alias] = $service->title;
            return $returnServices;
        }, []);

        $stocks = $this->stockRep->get(['id','title','alias']);
        $stocks = $stocks->reduce(function ($returnStocks, $stock) {
            $returnStocks[$stock->alias] = $stock->title;
            return $returnStocks;
        }, []);

        $portfolios = $this->galleryRep->get(['id','image'])->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->id] = $portfolio->image;
            return $returnPortfolios;
        }, []);

        $this->content = view(env('THEME').'.admin.layouts.menuCreate')
            ->with(['menu' => $menu, 'type' => $type, 'check' => $check, 'option' => $option, 'menus' => $menus,'categories' => $cats, 'articles' => $articles, 'portfolios' => $portfolios, 'services' => $services, 'pages' => $pages, 'stocks' => $stocks])->render();
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
        ), $id);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/menu/'.$id.'edit')->with($result);
        }
        return redirect('/admin/menu')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $result = $this->menuRep->deleteMenuByID($id);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/menu')->with($result);
        }
        return redirect('/admin/menu')->with($result);
    }

    /**
     * Get menu in array
     * @return mixed
     */
    public function getNav(){
        $menu = $this->menuRep->get();
        $mObj = Menu::make('NavAdmin', function($m) use ($menu){
            foreach ($menu as $item){
                $m->add($item->title, $item->url)->id($item->id);
            }
        });

        return $mObj;
    }

    public function getDataOfMenu(){
        $menu = $this->menuRep->get();

        return $menu;
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
            return $this->menuRep->actionMenu($request, $id);
        }
    }

    /**
     * Get item of menu by ID
     * @param $id
     * @return mixed
     */
    public function getMenuByID($id){
        return $this->menuRep->get('*', false, false, [['id', $id]], false)->first();
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
            if ($parentID == 0){
                $tree = '<option value="parent" '.($selectID == 'parent' ? 'selected':'').'>Раздел информации</option>';
            }
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
                $tree .= '<option value="'.$cat->alias.'" '.($selectID == $cat->alias ?'selected':'').' '.($currID == $cat->id ? 'disabled':'').'>'. $str . $cat->title ;
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
}
