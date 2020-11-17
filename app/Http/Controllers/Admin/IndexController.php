<?php

namespace Alice\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Alice\Http\Controllers\Controller;

class IndexController extends AdminController
{
    public function __construct() {
        parent::__construct();
        $this->template = env('THEME').'.admin.index';
    }

    /**
     * Output data to main page admin
     * @return $this
     * @throws \Throwable
     */
    public function index() {
        $this->title = 'Панель администратора';

        $this->content = view(env('THEME').'.admin.layouts.adminContent')->with('dashboard', $this->menuHTML)->render();
        return $this->renderOutput();
    }
}
