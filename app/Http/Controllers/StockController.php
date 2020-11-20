<?php

namespace Alice\Http\Controllers;

use Alice\Stock;
use Illuminate\Http\Request;
use Alice\Http\Controllers\SiteController;
use Illuminate\Support\Arr;

class StockController extends SiteController
{
    public function __construct(){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));
        $this->heading = true;
        $this->template = env('THEME').'.stock';
    }

    /**
     * Display a listing of the resource.
     * @return mixed
     * @throws \Throwable
     */
    public function index()
    {
        $stocks = Stock::query()->orderByDesc('updated_at')->get();

        $content = view(env('THEME').'.layouts.stockContent')->with('stocks', $stocks)->render();
        $this->vars = Arr::add($this->vars,'content', $content);

        return $this->renderOutput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Alice\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        $stock = Stock::query()->where('alias', $alias)->first();

        $this->title = $stock->title;
        $this->h_title = $stock->title;
        $this->page_desc = $stock->desc;
        $content = view(env('THEME').'.layouts.stockDetailContent')->with('stock', $stock);
        $this->vars = Arr::add($this->vars,'content', $content);
        $this->vars = Arr::add($this->vars,'meta_keywords', $stock->meta_keywords);
        $this->vars = Arr::add($this->vars,'meta_desc', $stock->meta_description);
        $this->vars = Arr::add($this->vars,'title', $this->title);
        return $this->renderOutput();
    }
}
