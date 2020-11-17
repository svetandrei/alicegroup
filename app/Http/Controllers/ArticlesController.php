<?php

namespace Alice\Http\Controllers;

use Alice\Category;
use Alice\Repositories\ArticlesRepository;
use Alice\Repositories\CategoryRepository;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\JsonLd;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ArticlesController extends SiteController {

    public function __construct(ArticlesRepository $articlesRep, CategoryRepository $catRep){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));

        $this->articlesRep = $articlesRep;
        $this->catRep = $catRep;
        $this->heading = true;
        $this->template = env('THEME').'.articles';
    }

    /**
     * Show all materials
     * @param bool $catAlias
     * @return $this
     * @throws \Throwable
     */
    public function index($catAlias = ''){
        //dd($catAlias);
        $data['categories'] = $this->getCategories($catAlias);
        $data['articles']  = $this->getArticles($catAlias);
        $data['category'] = $this->getCategoryByAlias($catAlias);

        if ($catAlias){
            $this->title = $data['category']->title;
            $this->h_title = $data['category']->title;
            $this->page_desc = $data['category']->desc . $data['category']->text;

            if(! JsonLd::isEmpty()) {
                JsonLdMulti::newJsonLd();
                JsonLdMulti::setType('NewsArticle');
                JsonLdMulti::addValues(['mainEntityOfPage' => [
                        '@id' => url("/informations"),
                        '@type' => 'WebPage']]
                    );
                JsonLdMulti::addValue('headline', $this->title);
                JsonLdMulti::setImages(Storage::url($data['category']->image));
                JsonLdMulti::addValue('datePublished', $data['category']->created_at);
                JsonLdMulti::addValue('dateModified', $data['category']->updated_at);
                JsonLdMulti::addValues(['author' => [
                        'name' => "Alice Group",
                        '@type' => 'Person']]
                );

                JsonLdMulti::addValues(['publisher' => [
                        'name' => "Alice Group",
                        '@type' => 'Organization',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => url('/images/logo.gif')
                            ]
                        ]
                    ]
                );
                JsonLdMulti::setDescription($data['category']->desc);
                JsonLdMulti::setUrl(false);
            }

        }

        $content = view(env('THEME').'.layouts.articlesContent')->with('data', $data)->render();
        $this->vars = Arr::add($this->vars,'content', $content);
        if ($data['category']){
            $this->vars = Arr::add($this->vars,'meta_keywords', $data['category']->meta_keywords);
            $this->vars = Arr::add($this->vars,'meta_desc', $data['category']->meta_desc);
        }
        $this->vars = Arr::add($this->vars,'title', $this->title);

        return $this->renderOutput();
    }

    /**
     * Get category by alias
     * @param $catAlias
     * @return bool
     */
    public function getCategoryByAlias($catAlias){
        if ($catAlias) {
            $arRes = $this->catRep->get('*', false, false, [['alias', $catAlias],['publish', 1]])->first();
        } else {
            return false;
        }
        return $arRes;
    }

    /**
     * Get all categories
     * @param bool $catAlias
     * @return bool
     */
    public function getCategories($catAlias = false){
        $where = false;
        if ($catAlias) {
            $id = $this->catRep->get('*', false, false, [['alias', $catAlias], ['publish', 1]])->first()->id;
            if ($id) {
                $where = [['parent_id', $id], ['publish', 1]];
            } else{ return false;}
        } else {
            $where = [['parent_id', 0], ['publish', 1]];
        }

        $res = $this->catRep->get('*', false, false, $where);
        return $res;
    }

    /**
     * Get all materials
     * @param bool $catAlias
     * @return bool
     */
    public function getArticles($catAlias = false){
        $where = false;
        if ($catAlias){
            $id = $this->catRep->get('id', false, false, [['alias', $catAlias],['publish', 1]])->first()->id;
            $where = [['category_id', $id], ['publish', 1]];
        } else {
            return false;
        }

        $res = $this->articlesRep->get('*', false, false, $where);
        return $res;
    }

}
