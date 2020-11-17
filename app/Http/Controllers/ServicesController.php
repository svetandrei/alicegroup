<?php

namespace Alice\Http\Controllers;

use Alice\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Alice\Service;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;

class ServicesController extends SiteController {
    protected $hasAccordion;

    public function __construct(ServicesRepository $servicesRep, Service $service){
        parent::__construct(new \Alice\Repositories\MenuRepository(new \Alice\Menu));

        $this->hasAccordion = $service;
        $this->heading = false;
        $this->servicesRep = $servicesRep;
        $this->template = env('THEME').'.services';
    }

    /**
     * Validation fields on page services
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
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
                if ($request->file('file')){
                    $image = $request->file('file');
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $new_name);
                    $getFile = public_path('images').$new_name;
                    $data = array_merge($data,['image' => $getFile]);
                }
                Mail::send(env('THEME').'.email', ['data'=> $data], function($message) use ($data) {
                    $mailAdmin = env('MAIL_ADMIN');
                    $message->from($mailAdmin, $data['name'], $data['message']);
                    $message->to($mailAdmin, 'Alice Group')->subject('Заказ услуги и цены');
                });
                if (!Mail::failures()){
                    $arg = [
                        'messages' => 'Заказ отправлен',
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
     * Show all materials
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->heading = true;
        $services['data']  = $this->getServices();
        $services['accordion'] = $this->getAccordions();
        $content = view(env('THEME').'.layouts.servicesContent')->with('services', $services)->render();
        $this->vars = Arr::add($this->vars,'content', $content);

        return $this->renderOutput();
    }

    /**
     * Show detail page of service
     * @param $slug
     * @return $this
     * @throws \Throwable
     */
    public function show($slug){
        $this->heading = false;
        $service['data'] = $this->getServiceByAlias($slug);
        $service['accordion'] = $this->getAccordions($slug);
        $this->title = $service['data']->title;
        $this->h_title = $service['data']->title;
        $this->page_desc = $service['data']->desc;

        if ($service['data']->images){
            $service['data']->images = json_decode($service['data']->images);
        }

        $content = view(env('THEME').'.layouts.serviceDetailContent')->with('service', $service);
        $this->vars = Arr::add($this->vars,'content', $content);
        $this->vars = Arr::add($this->vars,'meta_keywords', $service['data']['meta_keywords']);
        $this->vars = Arr::add($this->vars,'meta_desc', $service['data']['meta_description']);
        $this->vars = Arr::add($this->vars,'title', $this->title);

        return $this->renderOutput();
    }

    /**
     * Get all materials of service
     * @return bool
     */
    public function getServices(){
        $res = $this->servicesRep->get('*', false, false, [['publish', 1]], ['sort', 'ASC']);
        return $res;
    }

    /**
     * Get accordion of service slug
     * @param bool $alias
     * @return mixed
     */
    public function getAccordions($alias = false){
        $id = false;
        if ($alias) {
            $id = $this->servicesRep->get('id', false, false, [['alias', $alias], ['publish', 1]])->first()->id;
            return $this->hasAccordion->find($id)->accordions()->where([['publish', 1]])->orderBy('sort', 'asc')->get();
        } else {
            return $this->hasAccordion->from('accordion')->where([['service_id', 0],['publish', 1]])->get();
        }
    }

    /**
     * Get service page by alias
     * @param $alias
     * @return mixed
     */
    public function getServiceByAlias($alias){
        $res = $this->servicesRep->get('*', false, false, [['alias', $alias], ['publish', 1]])->first();
        return $res;
    }

    public function detailForm(Request $request){
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
                    $message->to($mailAdmin, 'Alice Group')->subject('Заказ услуги '.(isset($data['detailTitle']) && !empty($data['detailTitle']))? $data['detailTitle']:'');
                });
                if (!Mail::failures()){
                    $arg = [
                        'messages' => 'Заказ отправлен',
                        'class' => 'alert-success'
                    ];
                }
            }
            if ($arg) {
                return Response()->json($arg, 200);
            }
        }
    }
}
