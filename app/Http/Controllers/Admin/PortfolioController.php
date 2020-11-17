<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Portfolio;
use Alice\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Alice\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\UploadedFile;

class PortfolioController extends AdminController
{
    public function __construct(PortfolioRepository $gallery) {
        parent::__construct();
        $this->galleryRep = $gallery;
        $this->template = env('THEME').'.admin.gallery';
    }

    /**
     * Display a listing of the resource.
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер галлереи';
        $this->title_h = $this->title;
        $galleries = $this->getGallery();

        $this->content = view(env('THEME').'.admin.layouts.galleryContent')->with('galleries', $galleries)->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $result = $this->validator($request, array(
            'files.*' => 'image'
        ), false);
        return Response()->json($result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     */
    public function update(Request $request, $id) {

    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $result = $this->galleryRep->deleteGalleryByID($id);
        return Response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFileByID(Request $request, $id) {
        if($request->isMethod('post')) {
            $result = $this->validator($request, array(
                'file' => 'image'
            ), $id);
            return Response()->json($result, 200);
        }
    }

    /**
     * Get all gallery from storage
     * @return bool
     */
    public function getGallery(){
        return $this->galleryRep->get();
    }

    /**
     * Validate of field
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
            return $this->galleryRep->actionGallery($request, $id);
        }
    }

    /**
     * Delete selected images by IDs
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delSelectedImages(Request $request){
        if($request->isMethod('post')) {
            if ($request->all()){
                $imagesID = $request->get('imagesID')[0];
                $resIDs = $this->galleryRep->destroyByIDs($imagesID);
                if ($resIDs && is_array($resIDs)){
                    return Response()->json(['messages' => 'Выбранные изображения успешно удалены',
                        'class' => 'alert-success',
                        'result' => $resIDs
                    ], 200);
                } else {
                    return Response()->json(['messages' => 'Ошибка! Изображения не удалены',
                        'class' => 'alert-danger',
                    ], 200);
                }
            }
        }
    }

}
