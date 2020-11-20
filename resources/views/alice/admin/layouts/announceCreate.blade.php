{!! Form::open(['url' => (isset($announce->id)) ? route('announce.update',['announce' => $announce->alias]) : route('announce.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($announce->id))
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
                    {!! Form::text('title', isset($announce->title) ? $announce->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($announce->alias) ? $announce->alias : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="sort">Сортировка:</label>
                    {!! Form::text('sort', isset($announce->sort) ? $announce->sort : Request::old('sort'), ['class'=>'form-control', 'id' => 'sort']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="desc-price">Автор:</label>
                    {!! Form::select('author_id', $authors, isset($announce->author_id) ? $announce->author_id : '', ['class'=>'form-control', 'id' => 'authors', 'placeholder' => 'Авторы']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="meta-keywords">Ключевые слова:</label>
                    {!! Form::text('meta_keywords', isset($announce->meta_keywords) ? $announce->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-keywords']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="meta-description">Мета Описание:</label>
                    {!! Form::text('meta_description', isset($announce->meta_description) ? $announce->meta_description : Request::old('meta_description'), ['class'=>'form-control', 'id' => 'meta-description']) !!}
                </div>
            </div>
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', (isset($announce->publish)) ? $announce->publish : 1, isset($announce->publish) ? $announce->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
</div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short-desc">Краткое описание:</label>
                    {!! Form::textarea('desc', isset($announce->desc) ? $announce->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="text">Описание:</label>
                    {!! Form::textarea('text', isset($announce->text) ? $announce->text : Request::old('text'), ['id' => 'editor2', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($announce->image))
                    <div class="form-group">
                        <label>
                            Изображение анонса:
                        </label>
                        <div class="image-wrapper">
                        {!! Html::image(Storage::url($announce->image), "", ['class' => 'img-responsive img-thumbnail']) !!}
                        {!! Form::hidden('old_image', $announce->image) !!}
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