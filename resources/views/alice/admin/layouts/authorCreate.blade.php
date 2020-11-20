{!! Form::open(['url' => (isset($accordion->id)) ? route('author.update',['author' => $accordion->id]) : route('author.store'), 'class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @if(isset($author->id))
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
                    {!! Form::text('title', isset($author->title) ? $author->title : Request::old('title'), ['class'=>'form-control', 'id' => 'title']) !!}
                </div>
            </div>
            {{--<div class="col">--}}
                {{--<div class="form-group">--}}
                    {{--<label for="services">Услуга:</label>--}}
                    {{--{!! Form::select('service_id', $services, isset($author->service_id) ? $author->service_id : '', ['class'=>'form-control', 'id' => 'services', 'placeholder' => 'Услуги и цены']) !!}--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="custom-control mr-auto custom-checkbox">
                {{Form::hidden('publish', 0)}}
                {!! Form::checkbox('publish', isset($author->publish) ? $author->publish : 1, isset($author->publish) ? $author->publish : true , ['class' => 'custom-control-input check-input', 'id' => 'checkPublish'])!!}
                {!! Form::label('checkPublish', 'Опубликовать',['class' => 'custom-control-label']); !!}
            </div>
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
    });
</script>