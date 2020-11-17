 {!! Form::open(['url' => (isset($category->id)) ? route('category.update',['category' => $category->alias]) : route('category.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($category->id))
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
                    {!! Form::text('title', isset($category->title) ? $category->title  : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($category->alias) ? $category->alias  : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
                </div>
            </div>
        </div>
         <div class="row">
             <div class="col">
                 <div class="form-group">
                     <label for="url">Url:</label>
                     {!! Form::text('url', isset($category->url) ? $category->url  : Request::old('url'), ['class'=>'form-control', 'id' => 'url']) !!}
                 </div>
             </div>
             <div class="col">
                 <div class="form-group">
                     <label for="category">Категория:</label>
                     <select name="parent_id" class="form-control">
                         <option value="0">Верхний уровень</option>
                         {!! $categories !!}</select>
                     {{--{!! Form::select('parent_id', $categories, isset($category->service_id) ? $category->service_id : '', ['class'=>'form-control', 'id' => 'category', 'placeholder' => 'Услуги и цены']) !!}--}}
                 </div>
             </div>
         </div>
     <div class="row">
         <div class="col">
             <div class="form-group">
                 <label for="meta-keywords">Ключевые слова:</label>
                 {!! Form::text('meta_keywords', isset($category->meta_keywords) ? $category->meta_keywords : Request::old('meta_keywords'), ['class'=>'form-control', 'id' => 'meta-keywords']) !!}
             </div>
         </div>
         <div class="col">
             <div class="form-group">
                 <label for="meta-description">Мета Описание:</label>
                 {!! Form::text('meta_description', isset($category->meta_description) ? $category->meta_description : Request::old('meta_description'), ['class'=>'form-control', 'id' => 'meta-description']) !!}
             </div>
         </div>
     </div>
 <div class="row">
     <div class="col">
         <div class="form-group">
             <div class="custom-control mr-auto custom-checkbox">
                 {{Form::hidden('publish', 0)}}
                 {!! Form::checkbox('publish', isset($category->publish) ? $category->publish : 1, isset($category->publish) ? $category->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                 {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
             </div>
         </div>
     </div>
 </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short-desc">Краткое Описание:</label>
                    {!! Form::textarea('desc', isset($category->desc) ? $category->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="desc">Описание:</label>
                    {!! Form::textarea('text', isset($category->text) ? $category->text : Request::old('desc'), ['id' => 'editor2', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if(isset($category->image))
                    <div class="form-group">
                        <label>
                            Изображения материала:
                        </label>
                        <div class="image-wrapper">
                            {!! Html::image(Storage::url($category->image), "", ['class' => 'img-responsive img-thumbnail']) !!}
                            {!! Form::hidden('old_image', $category->image) !!}
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
                    {!! Form::button('Сохранить категорию', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
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