<?php

namespace Alice\Http\Controllers;

use Alice\Page;
use Alice\Repositories\PagesRepository;
use Alice\Service;
use Alice\Repositories\MenuRepository;
use Alice\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use Alice\Http\Requests;
use Illuminate\Support\Arr;
use Menu;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\JsonLd;

class SiteController extends Controller
{
    protected $articlesRep;
    protected $catRep;
    protected $servicesRep;
    protected $galleryRep;
    protected $startRep;
    protected $deliveryRep;
    protected $menuRep;
    protected $pageRep;
    protected $menu;

    protected $meta_keywords;
    protected $meta_desc;
    protected $title;
    protected $h_title;
    protected $page_desc;

    protected $heading = false;

    protected $sideTitle;
    protected $side = false;

    protected $template;
    protected $vars;

    public function __construct(MenuRepository $menuRep){
        $this->menuRep = $menuRep;
        $this->servicesRep = new ServicesRepository(new Service);
        $this->pageRep = new PagesRepository(new Page);
        $this->menu = $this->getMenu();
        foreach($this->menu->items as $arItem){
            if ($arItem->active){
                $dataMenu = $this->getDataOfPage($arItem->id);

                $this->vars = Arr::add($this->vars,'meta_keywords', $dataMenu->meta_keywords);
                $this->vars = Arr::add($this->vars,'meta_desc', $dataMenu->meta_description);
                $this->vars = Arr::add($this->vars,'title', $dataMenu->title);
                $this->h_title = $dataMenu->h_title;
                $this->page_desc = $dataMenu->text;
            }
        }
    }

    /**
     * Output parameters to template
     * @return $this
     * @throws \Throwable
     */
    protected function renderOutput(){

        SEOMeta::setTitle($this->vars['title']);
        SEOMeta::setDescription($this->vars['meta_desc']);
        SEOMeta::setCanonical(Request::capture()->url());
        SEOMeta::addKeyword($this->vars['meta_keywords']);

        SEOMeta::addMeta('viewport','width=device-width, initial-scale=1, shrink-to-fit=no','name');
        SEOMeta::addMeta('utf-8','','charset');
        SEOMeta::addMeta('msapplication-TileColor','#ffffff','name');
        SEOMeta::addMeta('msapplication-TileImage','/alice/favicon/ms-icon-144x144.png','name');
        SEOMeta::addMeta('theme-color','#ffffff');
        SEOMeta::addMeta('yandex-verification', '44f16588d80f7093', 'name');

        $this->vars = Arr::add($this->vars,'cover', $this->heading);

        $navigation = view(env('THEME').'.layouts.navigation')->with('menu', $this->menu)->render();
        $this->vars = Arr::add($this->vars,'navigation', $navigation);

        $heading = '';
        if($this->heading) {
            $heading = view(env('THEME').'.layouts.heading')->with(['h_title' => $this->h_title, 'page_desc' => $this->page_desc])->render();
        }
        $this->vars = Arr::add($this->vars,'heading', $heading);

        if($this->side) {
            $side = view(env('THEME').'.layouts.side')->with('sideTitle', $this->sideTitle)->render();
            $this->vars = Arr::add($this->vars,'side', $side);
        }

        $class = Request::capture()->segments();
        if (is_array($class) && isset($class[0])){
            $this->vars = Arr::add($this->vars, 'class_bg', $class[0]);
        }

        $header = view(env('THEME').'.layouts.header')->render();
        $this->vars = Arr::add($this->vars,'header', $header);

        $checkService['service'] = $this->getServicesByCheck();
        $checkService['product'] = $this->getProductByCheck();
        $checkService['policy'] = $this->getPageOfPolicy();

        $metaHeader = $this->getMetaHeader($this->vars);
        $this->vars = Arr::add($this->vars,'meta_header', $metaHeader);

        $footer = view(env('THEME').'.layouts.footer')->with('checkService', $checkService)->render();
        $this->vars = Arr::add($this->vars,'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    /**
     * Get data of page by id
     * @param $id
     * @return mixed
     */
    protected function getDataOfPage($id){
        $objPage = $this->menuRep->get('*', false, false, [['id', $id]], false)->first();
        return $objPage;
    }

    /**
     * Get menu in array
     * @return mixed
     */
    protected function getMenu(){
        $menu = $this->menuRep->get('*', false, false, [['publish', 1]], ['sort', 'asc']);
        $mObj = Menu::make('Nav', function($m) use ($menu){
            foreach ($menu as $item){
                $m->add($item->title, $item->url)->id($item->id);
            }
        });

        return $mObj;
    }

    public function getServicesByCheck(){
        $resService = $this->servicesRep->get('*', false, false, [['check_service', 1]], ['sort', 'ASC']);
        return $resService;
    }

    public function getProductByCheck(){
        $resService = $this->servicesRep->get('*', false, false, [['check_product', 1]], ['sort', 'ASC']);
        return $resService;
    }

    public function getPageOfPolicy(){
        $resPolicy = $this->pageRep->get('*', false, false, [['params', 'policy']], false);
        return $resPolicy;
    }

    public function getMetaHeader($meta){
        $html = '';
        $arMeta = [
            'headline' => [
                    'itemprop',
                    'Книжная типография "Элис групп"'
                ],
            'description' => [
                    'itemprop',
                    $meta['meta_desc']
                ],
            'keywords' => [
                    'itemprop',
                    $meta['meta_keywords']
                ]
            ];

        foreach ($arMeta as $key => $value) {
            $name = $value[0];
            $content = $value[1];

            $html .= "<meta {$name}=\"{$key}\" content=\"$content\">";
        }
        return $html;
    }
}
