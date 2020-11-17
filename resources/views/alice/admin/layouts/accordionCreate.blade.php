{!! Form::open(['url' => (isset($accordion->id)) ? route('accordion.update',['accordion' => $accordion->id]) : route('accordion.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($accordion->id))
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
                    {!! Form::text('title', isset($accordion->title) ? $accordion->title : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="services">Услуга:</label>
                    {!! Form::select('service_id', $services, isset($accordion->service_id) ? $accordion->service_id : '', ['class'=>'form-control', 'id' => 'services', 'placeholder' => 'Услуги и цены']) !!}
                </div>
            </div>
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', isset($accordion->publish) ? $accordion->publish : 1, isset($accordion->publish) ? $accordion->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="sort">Сортировка:</label>
            {!! Form::text('sort', isset($accordion->sort) ? $accordion->sort : Request::old('sort'), ['class'=>'form-control', 'id' => 'sort']) !!}
        </div>
    </div>
</div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="short-desc">Описание:</label>
                    {!! Form::textarea('desc', isset($accordion->desc) ? $accordion->desc : Request::old('desc'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group text-left">
                    {!! Form::button('Сохранить материал', ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
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

        CKEDITOR.replace('editor', {
            allowedContent: true,
        });
    });
</script>