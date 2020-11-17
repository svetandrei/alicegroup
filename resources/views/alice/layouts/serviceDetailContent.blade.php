<div class="container">
    <div class="content mx-auto py-5">
        <div itemtype="https://schema.org/Product" itemscope>
            <meta itemprop="name" content="{{$service['data']->title}}" />
            <link itemprop="image" href="{{ Storage::url($service['data']->images[0])}}" />
            <meta itemprop="description" content="{!!$service['data']->desc!!}" />
            <div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
                <link itemprop="url" href="{{ url(Request::url()) }}" />
                <meta itemprop="availability" content="https://schema.org/InStock" />
                <meta itemprop="priceCurrency" content="RU" />
                <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
                <meta itemprop="price" content="{{str_replace(".0", "", $service['data']->price)}}" />
                <meta itemprop="priceValidUntil" content="2029-11-20" />
                <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                    <meta itemprop="name" content="alice group" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 ">
                <h1>{{$service['data']->title}}</h1>
                <div class="detail-text">
                    {!!$service['data']->desc!!}
                </div>
            </div>

            @if ($service['data']->images)
            <div class="col-12 col-md-8 carousel-col">
                <div id="carouselExampleIndicators" class="carousel slide pointer-event" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($service['data']->images as $key => $itemImg)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="{{($key==0)?'active':''}}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($service['data']->images as $key => $itemImg)
                            <div class="carousel-item {{($key==0)?'active':''}}" data-src="{{Storage::url($itemImg)}}" data-download-url="false">
                                {!! Html::image(Storage::url($itemImg), "", ['class' => 'd-block w-100']) !!}
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.css" integrity="sha256-LvrAcvFsV6d8qTupmF/43JY8J0gB1hKVs8Hm2rAlcHc=" crossorigin="anonymous" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js" integrity="sha256-w14QFJrxOYkUnF0hb8pVFCSgYcsF0hMIKrqGb8A7J8A=" crossorigin="anonymous"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".carousel").lightGallery({
                            selector: '.carousel-item',
                            thumbnail: false,
                            animateThumb: false,
                            showThumbByDefault: false,
                            autoplayControls: false,
                            share: false,
                            actualSize: false,
                            fullScreen: false
                        });
                    });
                </script>
            @endif
        </div>
    </div>
</div>
<div class="section bg-gray py-5">
    <div class="container">
        <div class="card text-center card-price mx-auto py-5 shadow px-5">
            <div class="card-body">
                {{--<div class="info-price"> {{ ($service['data']->price && $service['data']->price > 0 ? ($service['data']->price != 3000?'От ':'').str_replace(".0", "", $service['data']->price).' '.Config::get('settings.currency'):'')}} {{$service['data']->addition_price}}</div>--}}
                {{--<p class="desc py-3">{!! $service['data']->desc_price !!}</p>--}}
                <a href="#" class="btn btn-lg orange-btn" data-target="#serviceModal" data-toggle="modal">Узнать стоимость</a>
            </div>
        </div>
    </div>
</div>
<div class="section py-5">
    <div class="container">
        <div class="detail-text mx-auto">
            {!!$service['data']->text!!}
        </div>
    </div>
</div>
@if ($service['accordion'])
<div class="section bg-gray py-5">
    <div class="container">
        <div id="accordion" class="py-5 mx-auto">
            @foreach($service['accordion'] as $key => $item)
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link d-flex align-items-center {{($key==0)?'':'collapsed'}}" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="{{($key==0)?'true':'false'}}" aria-controls="collapse{{$key}}">
                            <span>{{$item->title}}</span>
                            <span class="collapse-btn"><svg class="ml-auto" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <g stroke="none" stroke-width="2px" fill-rule="evenodd" stroke-linecap="square"> <g transform="translate(1.000000, 1.000000)" stroke="#000000"> <path d="M0,11 L22,11"></path> <path d="M11,0 L11,22"></path> </g> </g> </svg></span>
                        </button>
                    </h5>
                </div>

                <div id="collapse{{$key}}" class="collapse {{($key==0)?'show':''}}" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        {!!$item->desc!!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Modal -->
<div class="modal fade start-modal" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{--<img src="https://thumb.tildacdn.com/tild6131-3162-4365-b130-393366346630/-/format/webp/message-on-hold.jpg" alt=""/>--}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-title py-3">
                    Заполните пожалуйста
                </div>
                <div class="alert errors d-none" role="alert">
                </div>
                <form class="needs-validation" id="page_form">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        {!! Form::text('name', Request::old('name'), ['class'=>'form-control', 'id' => 'InputName', 'placeholder' => 'Ваше имя', 'required' => 'true']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', Request::old('email'), ['class'=>'form-control', 'id' => 'InputEmail', 'placeholder' => 'Ваш E-mail', 'required' => 'true']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('phone', Request::old('phone'), ['class' => 'form-control', 'id' => 'inputPhone', 'placeholder' => 'Ваш телефон'])!!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('message', Request::old('message'), ['id' => 'editor', 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Комментарии к заказу'])!!}
                    </div>
                    <div class="form-group">
                        <div class="custom-control mr-auto custom-checkbox">
                            {!! Form::checkbox('check', Request::old('check'), true , ['class' => 'custom-control-input form-check-input', 'id' => 'invalidCheck', 'required' => 'true'])!!}
                            {!! Html::decode(Form::label('invalidCheck', 'Нажимая кнопку отправить, вы даете согласие на <a href="/page/politika-konfidentsialnosti">обработку своих персональных данных</a>', ['class' => 'custom-control-label'])); !!}
                        </div>
                    </div>
                    {{Form::hidden('detailTitle', $service['data']->title)}}
                    {!! Form::submit('Отправить', ['class' => 'btn green-btn btn-lg']); !!}
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js" integrity="sha256-HQCkPjsckBtmO60xeZs560g8/5v04DvOkyEo01zhSpo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function(){
        $('#accordion').on('shown.bs.collapse', function(e){
            $('html, body').animate({
                scrollTop: $('#' + e.target.id).offset().top
            }, 1000);
        });

        $("#inputPhone").inputmask("+7(999) 999-99-99");
        $("#page_form").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                check: "required"
            },
            messages: {
                name: "Пожалуйста, введите Ваше имя.",
                email: {
                    required: "Введите ваш электронный адрес.",
                    email: "Неверно введён электронный адрес."
                },
                check: "Вы не предоставили согласие на обработку персональных данных."
            },
            errorClass: "invalid-feedback",
            validClass: "valid",
            highlight: function(element, errorClass, validClass) {
                $('#page_form').addClass('was-validated');
            },
            submitHandler: function(form) {
                var postData = new FormData();
                $.each(form, function(i, val) {
                    postData.append(val.name, val.value);
                });
                $.ajax({
                    url: '{{url('/detail-form')}}',
                    type: "POST",
                    processData: false,
                    contentType : false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: postData,
                    success: function( response ) {
                        var msg = JSON.parse(JSON.stringify(response));
                        $('.errors').removeClass('alert-danger alert-success').html('');
                        if (msg.messages){
                            if (Array.isArray(msg.messages)){
                                $.grep(msg.messages, function(el, arr) {
                                    $('.errors').append(el + '<br>').removeClass('d-none').addClass(msg.class);
                                });
                            } else {
                                $('.errors').append(msg.messages).removeClass('d-none').addClass(msg.class);
                                ym('62463733', 'reachGoal', 'ORDER'); return true;
                            }
                        }

                    }, errors: function( errors){
                        console.log(0);
                    }
                });

            }

        });
    });
</script>
