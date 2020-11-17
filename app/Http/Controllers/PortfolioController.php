<?php

namespace Alice\Http\Controllers;

use Alice\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PortfolioController extends SiteController
{
    public function __construct(PortfolioRepository $galleryRep){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));

        $this->galleryRep = $galleryRep;
        $this->heading = true;
        $this->template = env('THEME').'.gallery';
    }

    /**
     * Output data to portfolio page
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $gallery = $this->getPortfolio();
        $content = view(env('THEME').'.layouts.galleryContent')->with('gallery', $gallery)->render();
        $this->vars = Arr::add($this->vars,'content', $content);

        return $this->renderOutput();
    }

    /**
     * Get portfolio from storage
     * @return bool
     */
    public function getPortfolio(){
        $res = $this->galleryRep->get('*', false, false, [['publish', 1]], false);
        return $res;
    }
}
