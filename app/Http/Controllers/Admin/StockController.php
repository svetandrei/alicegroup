<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Stock;
use Alice\Http\Controllers\Admin\AdminController;
use Alice\Repositories\DefaultRepository;
use Alice\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class StockController extends AdminController
{
    protected $repo;
    public function __construct() {
        parent::__construct();
        $repo = new DefaultRepository(new Stock());
        $this->repo = $repo;
        $this->template = env('THEME').'.admin.stock';
    }

    /**
     * Output all materials
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер акции';
        $this->title_h = $this->title;

        $stocks = Stock::query()->orderByDesc('updated_at')->get();

        $this->content = view(env('THEME').'.admin.layouts.stockContent')->with('stocks', $stocks)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новую акцию';
        $this->title_h = $this->title;

        $this->content = view(env('THEME').'.admin.layouts.stockCreate')->render();
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
            'file' => 'image',
        ), false);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/stock/create')->with($result);
        }
        return redirect('/admin/stock')->with($result);
    }

    /**
     * Edit of material
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $stock = Stock::query()->where('alias', $alias)->first();
        $stock->images = json_decode($stock->images);

        $this->title = 'Реадактирование акции - '. $stock->title;
        $this->title_h = 'Реадактирование акции - <span>'. $stock->title . '</span>';

        $this->content = view(env('THEME').'.admin.layouts.stockCreate')
            ->with('stock', $stock)->render();
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
        ), $alias);

        if (is_array($result) && !empty($result['error'])){
            return redirect('/admin/stock/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/stock')->with($result);
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return $this
     */
    public function destroy($alias){
        $stock = Stock::query()->where('alias', $alias)->first();
        if (!is_null($stock) && $stock->delete()){
            return redirect('/admin/stock')->with(['status' => 'Материал '.$stock->title.' удален', 'class' => 'alert-success']);
        }
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
            return $this->actionStock($request, $alias);
        }
    }

    /**
     * Save and update material in storage
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionStock($request, $alias){
        $route = $request->capture()->segments();
        $service = '';
        if ($alias){
            $stock = Stock::query()->where('alias', $alias)->first();
        }
        $data = $request->except('_token', 'file');

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }

        $data['alias'] = $this->repo->transliterate($data['title']);

        $result = $this->repo->one($data['alias'],false);

        if(isset($result->id) && ($alias == false)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется.'];
        } else {
            if (isset($result->id) && ($result->id !== $stock->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if ($request->hasFile('file')) {
            $data['image'] = $this->repo->checkFile($request->file('file'), true, $route, 'thumbnail');
        }
        if ($request->hasFile('cover')) {
            $data['cover'] = $this->repo->checkFile($request->file('cover'), false, $route, '');
        }

        if ($alias){
            $stock->fill($data);
            if($stock->update()) {
                return ['status' => 'Материал обновлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не обновлен'];
            }
        } else {
            $this->repo->setModel->fill($data);
            if($this->repo->setModel->save()) {
                return ['status' => 'Материал добавлен', 'class' => 'alert-success'];
            } else {
                return ['error' => 'Ошибка! Материал не добавлен'];
            }
        }
    }
}
