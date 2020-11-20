{!! Form::open(['url' => (isset($menu->id)) ? route('menu.update',['menu' => $menu->id]) : route('menu.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($menu->id))
        @method('PUT')
    @endif
    @csrf
    @if (Session::has('error'))
        <div class="alert alert-danger">
            @if (is_array(Session::get('error')))
                @foreach (Session::get('error') as $error)
                    {{ $error }}<br>
                @endforeach
            @else
                {{Session::get('error')}}
            @endif
        </div>
    @endif
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="title">Заголовок пункта меню:</label>
            {!! Form::text('title', isset($menu->title) ? $menu->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="alias">Родитель пункта меню:</label>
            {!! Form::select('parent', $menus, isset($menu->parent) ? $menu->parent : null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="h_title">Заголовок страницы:</label>
            {!! Form::text('h_title', isset($menu->h_title) ? $menu->h_title : Request::old('h_title'), ['class'=>'form-control', 'id' => 'h_title']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="sort">Сортировка:</label>
            {!! Form::text('sort', isset($menu->sort) ? $menu->sort : Request::old('sort'), ['class'=>'form-control', 'id' => 'sort']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="meta-keywords">Ключевые слова:</label>
            {!! Form::text('meta_keywords', isset($page->meta_keywords) ? $page->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-keywords']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="meta-description">Мета Описание:</label>
            {!! Form::text('meta_description', isset($page->meta_keywords) ? $page->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-description']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', isset($menu->publish) ? $menu->publish : 1, isset($menu->publish) ? $menu->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="mb-0">
                            <div class="custom-control custom-radio">
                                {!! Form::radio('type', 'pageLink',(isset($type) && $type == 'pageLink') ? TRUE : FALSE,['class' => 'custom-control-input', 'id' => 'typeCustom1']) !!}
                                {!! Form::label('typeCustom1', 'Пользовательская ссылка', ['class' => 'custom-control-label']); !!}
                            </div>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {!! Form::label('typeCustom1', 'Ссылка на страницу', ['class' => '']); !!}
                                        {!! Form::select('page-alias', $pages, isset($option) ? $option : false, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <h5 class="mb-0">
                            <div class="custom-control custom-radio">
                                {!! Form::radio('type', 'infoLink',(isset($type) && $type == 'infoLink') ? TRUE : FALSE,['class' => 'custom-control-input', 'id' => 'typeCustom2']) !!}
                                {!! Form::label('typeCustom2', 'Раздел информации', ['class' => 'custom-control-label']); !!}
                            </div>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="title">Ссылка на категорию информации:</label>
                                        <select name="category-alias" class="form-control">
                                            <option value="0">Верхний уровень</option>
                                            {!! $categories !!}</select>
                                        {{--{!! Form::select('category-alias', $categories, (isset($option) && $option) ? $option :FALSE, ['class' => 'form-control']) !!}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <h5 class="mb-0">
                            <div class="custom-control custom-radio">
                                {!! Form::radio('type', 'serviceLink', (isset($type) && $type == 'serviceLink') ? TRUE : FALSE,['class' => 'custom-control-input', 'id' => 'typeCustom3']) !!}
                                {!! Form::label('typeCustom3', 'Раздел услуги', ['class' => 'custom-control-label']); !!}
                            </div>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="custom-control mr-auto custom-checkbox">
                                            {!! Form::checkbox('category-service', 'services', (isset($check['service']) && $check['service']) ? $check['service'] :false, ['class' => 'custom-control-input check-input', 'id' => 'serviceCheck'])!!}
                                            {!! Form::label('serviceCheck', 'Ссылка на раздел услуги', ['class' => 'custom-control-label']); !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="title">Ссылка на запись услуги:</label>
                                        {!! Form::select('service-alias', $services, (isset($option) && $option) ? $option :FALSE, ['class' => 'form-control', 'placeholder' => 'Не используется']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        <h5 class="mb-0">
                            <div class="custom-control custom-radio">
                                {!! Form::radio('type', 'galleryLink', (isset($type) && $type == 'galleryLink') ? TRUE : FALSE,['class' => 'custom-control-input', 'id' => 'typeCustom4']) !!}
                                {!! Form::label('typeCustom4', 'Раздел галереи', ['class' => 'custom-control-label']); !!}
                            </div>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="custom-control mr-auto custom-checkbox">
                                            {!! Form::checkbox('category-gallery', 'gallery', (isset($check['gallery']) && $check['gallery']) ? $check['gallery'] :false, ['class' => 'custom-control-input check-input', 'id' => 'galleryCheck'])!!}
                                            {!! Form::label('galleryCheck', 'Ссылка на раздел галереи', ['class' => 'custom-control-label']); !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                        <h5 class="mb-0">
                            <div class="custom-control custom-radio">
                                {!! Form::radio('type', 'stockLink', (isset($type) && $type === 'stockLink') ? TRUE : FALSE,['class' => 'custom-control-input', 'id' => 'typeCustom5']) !!}
                                {!! Form::label('typeCustom5', 'Раздел акции', ['class' => 'custom-control-label']); !!}
                            </div>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="custom-control mr-auto custom-checkbox">
                                            {!! Form::checkbox('category-stock', 'stocks', (isset($check['stock']) && $check['stock']) ? $check['stock'] :false, ['class' => 'custom-control-input check-input', 'id' => 'stockCheck'])!!}
                                            {!! Form::label('stockCheck', 'Ссылка на раздел акции', ['class' => 'custom-control-label']); !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="title">Ссылка на запись акции:</label>
                                        {!! Form::select('stock-alias', $stocks, (isset($option) && $option) ? $option :FALSE, ['class' => 'form-control', 'placeholder' => 'Не используется']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="page_desc">Под заголовок станицы:</label>
            {!! Form::textarea('text', isset($menu->text) ? $menu->text : Request::old('text'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            {!! Form::button('Сохранить пункт меню', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(function() {
        $(document).on('change', 'input.check-input', function () {
            if ($(this).prop('checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });

        CKEDITOR.replace('editor',{
                allowedContent: true,
            }
        );
    });
</script>
