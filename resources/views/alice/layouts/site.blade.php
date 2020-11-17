<!DOCTYPE html>
<html lang="ru">
<head>
   <link rel="apple-touch-icon" sizes="57x57" href="{{ asset(env('THEME').'/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset(env('THEME').'/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset(env('THEME').'/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(env('THEME').'/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset(env('THEME').'/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset(env('THEME').'/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset(env('THEME').'/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset(env('THEME').'/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(env('THEME').'/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset(env('THEME').'/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(env('THEME').'/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset(env('THEME').'/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(env('THEME').'/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset(env('THEME').'/favicon/manifest.json') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset(env('THEME').'/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700&subset=latin,cyrillic"/>

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    {!! SEOMeta::generate() !!}

    {{--<title>{{($title)? $title.' - Элис групп':'Элис групп'}}</title>--}}
    <link href="{{ asset(env('THEME').'/css/style.css') }}" rel="stylesheet">

    {!! JsonLdMulti::generate() !!}

</head>
<body>
<div class="wrapper">
    {{--@yield('side')--}}
    <header itemscope itemtype="http://schema.org/WPHeader">
        {!! $meta_header !!}
        @yield('meta_header')
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top" itemscope itemtype="http://schema.org/SiteNavigationElement">
            @yield('header')
            @yield('navigation')
        </nav>
    </header>
    <main role="main" class="bg-@yield('class_bg') @yield('class_bg') flex-shrink-0">
            @yield('cover')
            @yield('content')
    </main>
</div>
<footer class="footer mt-auto" itemscope="" itemType="http://schema.org/WPFooter">
    <div class="top pt-3 pb-5">
        <div class="container">
            <div class="row">
                @yield('footer')
            </div>
        </div>
    </div>
    <div class="bottom py-4">
        <div class="container">
            <span>© <span itemProp="copyrightYear">{{ Date::parse()->format('Y') }}</span> Alice Group </span>
        </div>
    </div>
</footer>
<!-- Modal -->
<div class="modal fade start-modal" id="startModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            {!! Html::decode(Form::label('invalidCheck', 'Нажимая кнопку «отправить», Вы даете согласие на <a href="/page/politika-konfidentsialnosti">обработку своих персональных данных</a>', ['class' => 'custom-control-label'])); !!}
                        </div>
                    </div>
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
                    url: '{{url('/page-form')}}' ,
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
                                ym(62463733,'reachGoal','ORDER'); return true;
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

<!-- noindex -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js"></script>
<script src="{{ asset(env('THEME').'/js/script.js') }}" type="text/javascript"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(62463733, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/62463733" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'eLkmGbZ5PC';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
<script src="{{ asset(env('THEME').'/js/cookieconsent.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset(env('THEME').'/css/cookieconsent.min.css') }}">
<script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#4d5358",
                    "text": "#898e94"
                },
                "button": {
                    "background": "#4d5358",
                    "text": "#bec0c2"
                }
            },
            "theme": "edgeless",
            "content": {
                "message": "С целью предоставления наиболее оперативного и индивидуализированного обслуживания на данном сайте используются cookie-файлы",
                "dismiss": ""
            }
        })});
</script>
<!-- /noindex -->
</body>
</html>
