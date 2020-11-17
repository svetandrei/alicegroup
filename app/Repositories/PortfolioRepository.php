<?php

namespace Alice\Repositories;

use Alice\Portfolio;

class PortfolioRepository extends Repository {
    public function __construct(Portfolio $gallery) {
        $this->model = $gallery;
    }

    /**
     * Save and update material in storage
     * @param $request
     * @param $id
     * @return array
     */
    public function actionGallery($request, $id){

        $gallery = '';
        if ($id){
            $gallery = Portfolio::where('id', $id)->first();
        }
        $data = $request->except('_token');

        $collection = collect($data);
        $data = $collection->filter(function ($value, $key) {
            return $value !== null;
        })->toArray();

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if ($request->hasFile('image') && $id){
            $data['image'] = $this->checkFile($request->file('image'), false, [1 => 'gallery'], 'gallery');
            $gallery->fill($data);
            $gallInfo = $gallery->update();
            if ($gallInfo){
                $newGallery = Portfolio::where('id', $id)->first();
                return ['result' => $newGallery,
                    'class' => 'alert-success',
                    'messages' => 'Изображение успешно обновлено'
                ];
            }
        }

        if ($request->hasFile('files')){
            $images = array();
            foreach ($request->file('files') as $image) {
                $data['image'] = $this->checkFile($image, false, [1 => 'gallery'], 'gallery');
                $gallInfo = Portfolio::create($data);
                $images[] = $gallInfo;
                $htmlGallery = $this->formingDataToHTML($images);
            }
            if ($images) {
                return ['result' => $htmlGallery,
                    'class' => 'alert-success',
                    'messages' => 'Изображения успешно загружены'
                ];
            }
        }
    }

    /**
     *
     * Delete material of storage
     * @param $id
     * @return array
     */
    public function deleteGalleryByID($id){
        $gallery = Portfolio::where('id', $id)->first();

        if($gallery->delete()) {
            return ['messages' => 'Изображение успешно удалено',
                'class' => 'alert-success',
                'result' => $gallery->id
            ];
        }
    }

    /**
     * Delete by IDs from storage table
     * @param $IDs
     * @return bool
     */
    public function destroyByIDs($IDs){
        try {
            $ids = explode(",", $IDs);
            $gallDel = Portfolio::find($ids)->each(function ($product, $key) {
                if (!$product->delete()){
                    return false;
                }
            });
            $resIDs = $gallDel->pluck('id')->toArray();
            if (!empty($resIDs) && is_array($resIDs)){
                return $resIDs;
            } else {return false;}
        }
        catch(Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Forming array of data to html
     * @param $data
     * @return string
     */
    public function formingDataToHTML($data){
        if ($data && is_array($data)){
            $html = '';
            foreach ($data as $key => $arData) {
                $html .= '<div class="col-lg-3 col-md-4 col-6" id="'.$arData->id.'">
                            <a href="javascript:void(0)" class="d-block mb-4 h-100">
                                <div class="image-wrapper img-thumbnail">
                                    <img src="'.env('APP_URL').'/storage/'.$arData->image.'" class="img-fluid" alt="">
                                </div>
                                <div class="card-body d-flex">
                                    <div class="custom-control mr-auto custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check-input" name="delete[]" id="customCheck'.$arData->id.'" value="'.$arData->id.'">
                                        <label class="custom-control-label" for="customCheck'.$arData->id.'">Выбрать</label>
                                    </div>
                                    <form method="POST" action="'.env('APP_URL').'/admin/update_file/'.$arData->id.'" accept-charset="UTF-8" class="form-horizontal form-edit" enctype="multipart/form-data">
                                        <input name="_token" type="hidden" value="'.csrf_token().'">
                                        <input type="hidden" name="_method" value="PUT">                                                        
                                        <div class="btn btn-sm btn-primary edit-image btn-circle">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="edit" class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>
                                            <input id="editFile'.$arData->id.'" class="edit-file-input" name="image" type="file">
                                        </div>
                                        <input name="id_image" type="hidden" value="'.$arData->id.'">
                                    </form>
                                    <form method="POST" action="'.env('APP_URL').'/admin/gallery/'.$arData->id.'" accept-charset="UTF-8" class="form-horizontal form-delete"><input name="_token" type="hidden" value="'.csrf_token().'">
                                        <input name="id_image" type="hidden" value="'.$arData->id.'">
                                        <button class="btn btn-sm btn-danger delete-image btn-circle" type="submit">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </a>
                        </div>';
            }
            return $html;
        }
    }
}

?>