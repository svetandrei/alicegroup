{!! Form::open(['url' => (isset($page->id)) ? route('page.update',['page' => $page->alias]) : route('page.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($page->id))
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
                    {!! Form::text('title', isset($page->title) ? $page->title : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="alias">Псевдоним:</label>
                    {!! Form::text('alias', isset($page->alias) ? $page->alias : Request::old('alias'), ['class'=>'form-control', 'id' => 'alias']) !!}
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
                {!! Form::checkbox('publish', isset($page->publish) ? $page->publish : 1, isset($page->publish) ? $page->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
</div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="short-desc">Описание:</label>
                    {!! Form::textarea('text', isset($page->text) ? $page->text : Request::old('text'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="param">Параметры:</label>
                    {!! Form::text('params', isset($page->params) ? $page->params : Request::old('params'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group text-left">
                    {!! Form::button('Сохранить страницу', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
                </div>
            </div>
        </div>
{!! Form::close() !!}
<script type="text/javascript">
    $(function(){
        $(document).on('change', 'input.check-input', function(){
            if ($(this).prop('checked')){
                $(this).val(1);
            } else {$(this).val(0);}
        });

        CKEDITOR.replace('editor',{
            allowedContent: true,
            }
        );
    });
</script>