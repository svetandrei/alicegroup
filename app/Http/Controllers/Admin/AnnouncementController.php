<?php

namespace Alice\Http\Controllers\Admin;

use Alice\Announcement;
use Alice\Author;
use Alice\Http\Controllers\Admin\AdminController;
use Alice\Repositories\DefaultRepository;
use Alice\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends AdminController
{
    protected $repo;
    public function __construct() {
        parent::__construct();
        $repo = new DefaultRepository(new Announcement());
        $this->repo = $repo;
        $this->template = env('THEME').'.admin.announce';
    }

    /**
     * Output all materials
     * @return $this
     * @throws \Throwable
     */
    public function index(){
        $this->title = 'Менеджер анонсов';
        $this->title_h = $this->title;

        $announces = Announcement::query()->orderByDesc('updated_at')->get();

        $this->content = view(env('THEME').'.admin.layouts.announceContent')->with('announces', $announces)->render();
        return $this->renderOutput();
    }

    /**
     * Form of create material
     * @return $this
     * @throws \Throwable
     */
    public function create(){
        $this->title = 'Добавить новый анонс';
        $this->title_h = $this->title;

        $authors = Author::query()->select(['id', 'title'])->get();
        $arAuthor = array();
        foreach ($authors as $author) {
            $arAuthor[$author->id] = $author->title;
        }

        $this->content = view(env('THEME').'.admin.layouts.announceCreate')->with('authors', $arAuthor)->render();
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
            return redirect('/admin/announce/create')->with($result);
        }
        return redirect('/admin/announce')->with($result);
    }

    /**
     * Edit of material
     * @param $alias
     * @return $this
     * @throws \Throwable
     */
    public function edit($alias){
        $announce = Announcement::query()->where('alias', $alias)->first();
        $announce->images = json_decode($announce->images);

        $this->title = 'Реадактирование анонса - '. $announce->title;
        $this->title_h = 'Реадактирование анонса - <span>'. $announce->title . '</span>';

        $authors = Author::query()->select(['id', 'title'])->get();
        $arAuthor = array();
        foreach ($authors as $author) {
            $arAuthor[$author->id] = $author->title;
        }

        $this->content = view(env('THEME').'.admin.layouts.announceCreate')
            ->with('announce', $announce)
            ->with('authors', $arAuthor)->render();
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
            return redirect('/admin/announce/'.$alias.'/edit')->with($result);
        }
        return redirect('/admin/announce')->with($result);
    }

    /**
     * Delete material from storage
     * @param $alias
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($alias){
        $announce = Announcement::query()->where('alias', $alias)->first();
        if (!is_null($announce) && $announce->delete()){
            return redirect('/admin/announce')->with(['status' => 'Материал '.$announce->title.' удален', 'class' => 'alert-success']);
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
            return $this->actionAnnounce($request, $alias);
        }
    }

    /**
     * Save and update material in storage
     * @param $request
     * @param $alias
     * @return array
     */
    public function actionAnnounce($request, $alias){
        $route = $request->capture()->segments();
        $service = '';
        if ($alias){
            $announce = Announcement::query()->where('alias', $alias)->first();
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
            if (isset($result->id) && ($result->id !== $announce->id)){
                $request->merge(array('alias' => $data['alias']));
                $request->flash();
                return ['error' => 'Данный псевдоним уже используется.'];
            }
        }

        if ($request->hasFile('file')) {
            $data['image'] = $this->repo->checkFile($request->file('file'), false, $route, 'thumbnail');
        }

        if ($alias){
            $announce->fill($data);
            if($announce->update()) {
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
