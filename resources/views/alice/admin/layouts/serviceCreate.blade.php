{!! Form::open(['url' => (isset($service->id)) ? route('services.update',['service' => $service->alias]) : route('services.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($service->id))
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
                    <label for="title">Заголовок:</label>
                    {!! Form::text('title', isset($service->title) ? $service->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($service->alias) ? $service->alias : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="price">Цена:</label>
                            {!! Form::text('price', isset($service->price) ? str_replace(".0", "", $service->price) : str_replace(".0", "", Request::old('price')), ['class'=>'form-control', 'id' => 'price']) !!}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="addition-price">Дополнение к цене:</label>
                            {!! Form::text('addition_price', isset($service->addition_price) ? $service->addition_price : Request::old('addition_price'), ['class'=>'form-control', 'id' => 'addition-price']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="desc-price">Описание к цене:</label>
                    {!! Form::text('desc_price', isset($service->desc_price) ? $service->desc_price : Request::old('desc_price'), ['class'=>'form-control', 'id' => 'desc-price']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="meta-keywords">Ключевые слова:</label>
                    {!! Form::text('meta_keywords', isset($service->meta_keywords) ? $service->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-keywords']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="meta-description">Мета Описание:</label>
                    {!! Form::text('meta_description', isset($service->meta_keywords) ? $service->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-description']) !!}
                </div>
            </div>
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', (isset($service->publish)) ? $service->publish : 1, isset($service->publish) ? $service->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="sort">Сортировка:</label>
            {!! Form::text('sort', isset($service->sort) ? $service->sort : Request::old('sort'), ['class'=>'form-control', 'id' => 'sort']) !!}
        </div>
    </div>
</div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <div class="custom-control mr-auto custom-checkbox">
                        {{Form::hidden('check_service', 0)}}
                        {!! Form::checkbox('check_service', isset($service->check_service) ? $service->check_service : Request::old('check_service'), (isset($service->publish) && $service->check_service) ? $service->check_service : false , ['class' => 'custom-control-input check-input', 'id' => 'checkService'])!!}
                        {!! Form::label('checkService', 'Выводить пункт в Услуги (подвал сайта)',['class' => 'custom-control-label']); !!}
                    </div>
                    <div class="custom-control mr-auto custom-checkbox">
                        {{Form::hidden('check_product', 0)}}
                        {!! Form::checkbox('check_product', isset($service->check_product) ? $service->check_product : Request::old('check_product'), (isset($service->publish) && $service->check_product) ? $service->check_product : false, ['class' => 'custom-control-input check-input', 'id' => 'checkProduct'])!!}
                        {!! Form::label('checkProduct', 'Выводить пункт в Продукцию (подвал сайта)',['class' => 'custom-control-label']); !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short-desc">Краткое описание:</label>
                    {!! Form::textarea('desc', isset($service->desc) ? $service->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="text">Описание:</label>
                    {!! Form::textarea('text', isset($service->text) ? $service->text : Request::old('text'), ['id' => 'editor2', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($service->images))
                    <div class="form-group">
                        <label>
                            Изображения слайдера:
                        </label>
                        <div class="image-wrapper">
                            @foreach($service->images as $key => $img)
                                {!! Html::image(Storage::url($img), "", ['class' => 'img-responsive img-thumbnail']) !!}
                            @endforeach

                        </div>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="files">Мультизагрузка изображений:</label>
                    <div class="custom-file">
                        {!! Form::file('files[]', ['id' => 'customFile', 'class' => 'custom-file-input', 'multiple', 'data-show-upload' =>'true', 'data-show-caption' => 'true'])!!}
                        {!! Form::label('files', 'Выберите файл', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($service->image))
                    <div class="form-group">
                        <label>
                            Изображение материала:
                        </label>
                        <div class="image-wrapper">
                        {!! Html::image(Storage::url($service->image), "", ['class' => 'img-responsive img-thumbnail']) !!}
                        {!! Form::hidden('old_image', $service->image) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="file">Загрузка изображения:</label>
                    <div class="custom-file">
                        {!! Form::file('file', ['id' => 'customFile2', 'class' => 'custom-file-input'])!!}
                        {!! Form::label('file', 'Выберите файл', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group text-right">
                    {!! Form::button('Сохранить услугу', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
                </div>
            </div>
        </div>
{!! Form::close() !!}
<script type="text/javascript">
    $(function(){
        $('#customFile, #customFile2').on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next().html(fileName);
        });

        $(document).on('change', 'input.check-input', function(){
            if ($(this).prop('checked')){
                $(this).val(1);
            } else {$(this).val(0);}
        });

        CKEDITOR.replace( 'editor' , {
            allowedContent: true,
        });
        CKEDITOR.replace( 'editor2', {
            allowedContent: true,
        });
    });
</script>