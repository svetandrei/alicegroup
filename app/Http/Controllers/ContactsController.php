<?php

namespace Alice\Http\Controllers;

use Illuminate\Http\Request;
use Alice\Http\Requests;
use Illuminate\Support\Arr;

class ContactsController extends SiteController
{
    public function __construct(){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));

        $this->template = env('THEME').'.contacts';
    }

    /**
     * Output data to contact page
     * @return $this
     * @throws \Throwable
     */
    public function index(){

        $content = view(env("THEME").".layouts.contactContent")->with('page_desc', $this->page_desc)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        return $this->renderOutput();
    }
}
