<?php

namespace Alice\Http\Controllers;

use Alice\Repositories\PagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;

class PageController extends SiteController
{
    public function __construct(PagesRepository $page){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));
        $this->pageRep = $page;
        $this->heading = true;
        $this->template = env('THEME').'.page';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if($request->isMethod('post')) {
            $arg = array();
            $validator = Validator::make($request->all(), array(
                'name' => 'required|max:255',
                'email' => 'required|email',
                'check' => 'accepted'
            ), Lang::get('validation'), Lang::get('validation.attributes'));

            if ($validator->fails()) {
                $arg = [
                    'messages' => $validator->errors()->all(),
                    'class' => 'alert-danger'
                ];
            } else {
                $data = $request->all();
                Mail::send(env('THEME').'.email', ['data'=> $data], function($message) use ($data) {
                    $mailAdmin = env('MAIL_ADMIN');
                    $message->from($mailAdmin, 'Alice Group', $data['phone']);
                    $message->to($mailAdmin, 'Alice Group')->subject('Заявка с Alice Group');
                });
                if (!Mail::failures()){
                    $arg = [
                        'messages' => 'Заявка отправлена',
                        'class' => 'alert-success'
                    ];
                }
            }
            if ($arg) {
                return Response()->json($arg, 200);
            }
        }
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function page($alias)
    {
        $page = $this->getPageByAlias($alias)->first();

        if ($page->params == 'contact'){
            $this->heading = false;
            $content = view(env('THEME').'.layouts.contactContent')->with('page', $page)->render();
        } elseif ($page->params == 'policy'){
            $this->heading = false;
            $this->vars = Arr::add($this->vars,'title', $page->title);
            $content = view(env('THEME').'.layouts.pageContent')->with('page', $page)->render();
        }
        else {
            //$this->h_title = $page->title;
            $this->vars = Arr::add($this->vars,'title', $page->title);
            $this->vars = Arr::add($this->vars,'h_title', $page->title);
            $content = view(env('THEME').'.layouts.pageContent')->with('page', $page)->render();
        }
        $this->vars = Arr::add($this->vars, 'class_bg', $page->params);
        $this->vars = Arr::add($this->vars,'meta_keywords', $page->meta_keywords);
        $this->vars = Arr::add($this->vars,'meta_desc', $page->meta_desc);
        $this->vars = Arr::add($this->vars,'content', $content);

        return $this->renderOutput();
    }

    /**
     * Get data of page by Alias
     * @param $alias
     * @return bool
     */
    public function getPageByAlias($alias){
        return $this->pageRep->get('*', false, false, [['alias', $alias],['publish', 1]], false);
    }
}
