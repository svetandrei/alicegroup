<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Accordion;
use Alice\Service;
use Alice\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AccordionController extends AdminController {
    protected $resAccord;

    public function __construct(Accordion $accord) {
        parent::__construct();
        $this->resAccord = $accord;
        $this->template = env('THEME').'.admin.accordion';
    }

    /**
     * Output all accordion 
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер аккордеонов';
        $this->title_h = $this->title;
        $accordions = Accordion::all();
        $this->content = view(env('THEME').'.admin.layouts.accordionContent')
            ->with('accordions', $accordions)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новый аккордеон';
        $this->title_h = $this->title;

        $services = Service::select(['id', 'title'])->get();
        $arService = array();
        foreach ($services as $service) {
            $arService[$service->id] = $service->title;
        }

        $this->content = view(env('THEME').'.admin.layouts.accordionCreate')->with('services', $arService)->render();
        return $this->renderOutput();
    }

    /**
     * Create material
     * @param Request $request
     * @return $this
     */
    public function store(Request $request){

        $result = $this->validator($request, array(
            'title' => 'required|max:255',
            'desc' => 'required'
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/accordion/create')->with($result);
        }
        return redirect('/admin/accordion')->with($result);
    }

    /**
     * Edit material by id
     * @param $id
     * @return $this
     * @throws \Throwable
     */
    public function edit($id){
        $accordion = Accordion::where('id', $id)->first();

        $this->title = 'Редактирование аккордеона - '. $accordion->title;
        $this->title_h = 'Редактирование аккордеона - <span>'. $accordion->title . '</span>';
        $services = Service::select(['id', 'title'])->get();
        $arService = array();
        foreach ($services as $service) {
            $arService[$service->id] = $service->title;
        }

        $this->content = view(env('THEME').'.admin.layouts.accordionCreate')->with('accordion', $accordion)->with('services', $arService)->render();
        return $this->renderOutput();
    }

    /**
     * Update material by id
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function update(Request $request, $id) {
        $result = $this->validator($request, array(
            'title' => 'required|max:255',
            'desc' => 'required'
        ), $id);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/accordion/'.$id.'/edit')->with($result);
        }
        return redirect('/admin/accordion')->with($result);
    }

    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $id
     * @return array
     */
    public function validator($request, $rules, $id){
        $result = array();
        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'error' => $validator->errors()->all(),
                'class' => 'alert-danger'
            ];
        } else {
            return $this->actionAccordion($request, $id);
        }
    }

    /**
     * Delete material from storage
     * @param $id
     * @return $this
     */
    public function destroy($id){
        $result = $this->deleteAccordionByID($id);

        if(is_array($result) && !empty($result['error'])) {
            return redirect('/admin/accordion')->with($result);
        }
        return redirect('/admin/accordion')->with($result);
    }

    /**
     * Save and update material to storage
     * @param $request
     * @param $id
     * @return array
     */
    public function actionAccordion($request, $id){
        $route = $request->capture()->segments();
        $accordion = '';
        if ($id){
            $accordion = Accordion::where('id', $id)->first();
        }

        $data = $request->except('_token');

        $collection = collect($data);
        $data = $collection->filter(function ($value, $key) {
            return $value !== null;
        })->toArray();

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if ($id){
            $accordion->fill($data);
            if($accordion->update()) {
                return ['status' => 'Материал обновлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            if(Accordion::create($data)) {
                return ['status' => 'Материал добавлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }

    /**
     * Delete by id from storage
     * @param $id
     * @return array
     */
    public function deleteAccordionByID($id){
        $accordion = Accordion::where('id', $id)->first();

        if($accordion->delete()) {
            return ['status' => 'Материал '.$accordion->title.' удален', 'class' => 'alert-success'];
        }
    }
}
