<?php

namespace Alice\Http\Controllers;

use Alice\Portfolio;
use Alice\Repositories\PortfolioRepository;
use Alice\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Alice\Page;

class HomeController extends SiteController
{

    public function __construct(){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));

        $this->side = true;
        $this->template = env('THEME').'.home';
    }

    /**
     * Output home page
     * @return $this
     * @throws \Throwable
     */
    public function index() {
        $this->sideTitle = 'Создадим книгу из рукописи';

        $home = Page::query()->where('params','home')->first();
        $services = $this->servicesRep->get('*', false, false, [['publish', 1]], ['sort', 'ASC']);
        $page = $this->pageRep->get('*', false, false, [['publish', 1],['params','start']], false)->first();
        $gallery = Portfolio::query()->where('publish', 1)->take(10)->get();

        $content = view(env('THEME').'.layouts.homeContent')->with('sideTitle', $this->sideTitle)
            ->with('home', $home)
            ->with('services', $services)
            ->with('gallery', $gallery)
            ->with('page', $page)->render();
        $this->vars = Arr::add($this->vars,'content', $content);
        $this->vars = Arr::add($this->vars,'title', $home->title);
        $this->vars = Arr::add($this->vars,'meta_keywords', $home->meta_keywords);
        $this->vars = Arr::add($this->vars,'meta_desc', $home->meta_description);

        return $this->renderOutput();
    }
}
