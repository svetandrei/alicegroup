<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Service;
use Alice\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Alice\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class ServicesController extends AdminController {

    public function __construct(ServicesRepository $service) {
        parent::__construct();
        $this->servicesRep = $service;
        $this->template = env('THEME').'.admin.services';
    }

    /**
     * Output all materials
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер услуг';
        $this->title_h = $this->title;

        $services = $this->getServices();

        $this->content = view(env('THEME').'.admin.layouts.servicesContent')->with('services', $services)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новую услугу';
        $this->title_h = $this->title;

        $this->content = view(env('THEME').'.admin.layouts.serviceCreate')->render();
        return $this->renderOutput();
    }

    /**
     * Create and save new material
     * @param Request $request
     * @return $this
     */
    public function store(Request $request){

        $result = $this->validator($request, array(
            'title' => 'required|max:255',
            'file' => 'required|image',
            'files' => 'required',
            'files.*' => 'image'
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/services/create')->with($result);
        }
        return redirect('/admin/services')->with($result);
    }

    /**
     * Edit of material
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $service = Service::where('alias', $alias)->first();
        $service->images = json_decode($service->images);

        $this->title = 'Реадактирование услуги - '. $service->title;
        $this->title_h = 'Реадактирование услуги - <span>'. $service->title . '</span>';
        $this->content = view(env('THEME').'.admin.layouts.serviceCreate')->with('service', $service)->render();
        return $this->renderOutput();
    }

    /**
     * Update material
     * @param Request $request
     * @param $alias
     * @return $this
     */
    public function update(Request $request, $alias)
    {
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
            'file' => 'image',
            'files.*' => 'image'
        ), $alias);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/services/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/services')->with($result);
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return $this
     */
    public function destroy($alias){
        $result = $this->servicesRep->deleteServiceByAlias($alias);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/services')->with($result);
        }
        return redirect('/admin/services')->with($result);
    }

    /**
     * Validate of field
     * @param $request
     * @param $rules
     * @param $alias
     * @return array
     */
    public function validator($request, $rules, $alias){
        $result = array();
        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->servicesRep->actionService($request, $alias);
        }
    }

    /**
     * Get data of articles
     * @return bool
     */
    public function getServices(){
        $res = $this->servicesRep->get('*',false, false, false, ['updated_at','DESC']);
        return $res;
    }
}
