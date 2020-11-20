<?php

namespace Alice\Http\Controllers;

use Alice\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Alice\Http\Controllers\SiteController;

class AnnouncementController extends SiteController
{
    public function __construct(){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));
        $this->heading = true;
        $this->template = env('THEME').'.announce';
    }


    /**
     * Display the specified resource.
     * @param $alias
     * @return AnnouncementController
     * @throws \Throwable
     */
    public function show($alias)
    {
        $this->heading = false;
        $announce = Announcement::query()->where('alias', $alias)->first();

        $this->title = $announce->title;
        $this->h_title = $announce->title;
        $this->page_desc = $announce->desc;
        $content = view(env('THEME').'.layouts.announceDetailContent')->with('announce', $announce);
        $this->vars = Arr::add($this->vars,'content', $content);
        $this->vars = Arr::add($this->vars,'meta_keywords', $announce->meta_keywords);
        $this->vars = Arr::add($this->vars,'meta_desc', $announce->meta_description);
        $this->vars = Arr::add($this->vars,'title', $this->title);
        return $this->renderOutput();
    }

}
