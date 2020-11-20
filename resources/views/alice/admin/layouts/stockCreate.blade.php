{!! Form::open(['url' => (isset($stock->id)) ? route('stock.update',['stock' => $stock->alias]) : route('stock.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($stock->id))
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
                    {!! Form::text('title', isset($stock->title) ? $stock->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($stock->alias) ? $stock->alias : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="sort">Сортировка:</label>
                    {!! Form::text('sort', isset($stock->sort) ? $stock->sort : Request::old('sort'), ['class'=>'form-control', 'id' => 'sort']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="meta-keywords">Ключевые слова:</label>
                    {!! Form::text('meta_keywords', isset($stock->meta_keywords) ? $stock->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-keywords']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="meta-description">Мета Описание:</label>
                    {!! Form::text('meta_description', isset($stock->meta_description) ? $stock->meta_description : Request::old('meta_description'), ['class'=>'form-control', 'id' => 'meta-description']) !!}
                </div>
            </div>
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', (isset($stock->publish)) ? $stock->publish : 1, isset($stock->publish) ? $stock->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
</div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short-desc">Краткое описание:</label>
                    {!! Form::textarea('desc', isset($stock->desc) ? $stock->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="text">Описание:</label>
                    {!! Form::textarea('text', isset($stock->text) ? $stock->text : Request::old('text'), ['id' => 'editor2', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($stock->image))
                    <div class="form-group">
                        <label>
                            Изображение детальное:
                        </label>
                        <div class="image-wrapper">
                            {!! Html::image(Storage::url($stock->cover), "", ['class' => 'img-responsive img-thumbnail']) !!}
                            {!! Form::hidden('old_cover', $stock->cover) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="file">Загрузка детального изображения:</label>
                    <div class="custom-file">
                        {!! Form::file('cover', ['id' => 'customFile', 'class' => 'custom-file-input'])!!}
                        {!! Form::label('cover', 'Выберите файл', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($stock->image))
                    <div class="form-group">
                        <label>
                            Изображение анонса:
                        </label>
                        <div class="image-wrapper">
                        {!! Html::image(Storage::url($stock->image), "", ['class' => 'img-responsive img-thumbnail']) !!}
                        {!! Form::hidden('old_image', $stock->image) !!}
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
                    {!! Form::button('Сохранить анонс', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
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