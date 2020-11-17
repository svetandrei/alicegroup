{!! Form::open(['url' => (isset($article->id)) ? route('informations.update',['information' => $article->alias]) : route('informations.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($article->id))
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
                    {!! Form::text('title', isset($article->title) ? $article->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($article->alias) ? $article->alias : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="url">Url:</label>
                    {!! Form::text('url', isset($article->url) ? $article->url : Request::old('url'), ['class'=>'form-control', 'id' => 'url']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="cat">Категория:</label>
                    <select name="category_id" class="form-control">{!! $categories !!}</select>
                </div>
            </div>
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', isset($article->publish) ? $article->publish : 1, isset($article->publish) ? $article->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>

        </div>
    </div>
</div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short-desc">Краткое описание:</label>
                    {!! Form::textarea('desc', isset($article->desc) ? $article->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="text">Описание:</label>
                    {!! Form::textarea('text', isset($article->text) ? $article->text : Request::old('text'), ['id' => 'editor2', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($article->image))
                    <div class="form-group">
                        <label>
                            Изображения материала:
                        </label>
                        <div class="image-wrapper">
                        {!! Html::image(Storage::url($article->image), "", ['class' => 'img-responsive img-thumbnail']) !!}
                        {!! Form::hidden('old_image', $article->image) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="file">Загрузка изображения:</label>
                    <div class="custom-file">
                        {!! Form::file('file', ['id' => 'customFile', 'class' => 'custom-file-input'])!!}
                        {!! Form::label('file', 'Выберите файл', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group text-right">
                    {!! Form::button('Сохранить информацию', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
                </div>
            </div>
        </div>
{!! Form::close() !!}
<script type="text/javascript">
    $(function(){
        $('#customFile').on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        });

        $(document).on('change', 'input.check-input', function(){
            if ($(this).prop('checked')){
                $(this).val(1);
            } else {$(this).val(0);}
        });

        CKEDITOR.replace( 'editor', {
            allowedContent: true,
        });
        CKEDITOR.replace( 'editor2', {
            allowedContent: true,
        });
    });
</script>