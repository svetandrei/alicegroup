<div class="section form bg-gray-dark py-5">
    <div class="container">
        <h3 class="">Сделайте заказ</h3>
        <p class="lead">Отправьте контакты, информацию о своем заказе и загрузите макет. Мы свяжемся с Вами для подтверждения и уточнения деталей заказа.</p>
        <div class="alert errors d-none" role="alert">
        </div>
        {{--{!! Form::open([ 'class'=> 'py-4 needs-validation', 'method'=>'POST', 'enctype'=>'multipart/form-data', 'novalidate']) !!}--}}

        <form class="py-4 needs-validation" id="service_form" method="post" enctype="multipart/form-data" novalidate>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="form-group py-2">
                {!! Form::text('name', Request::old('name'), ['class'=>'form-control rounded-0', 'id' => 'InputName', 'placeholder' => 'Ваше имя', 'required' => 'true']) !!}
            </div>
            <div class="form-group py-2">
                {!! Form::email('email', Request::old('email'), ['class'=>'form-control rounded-0', 'id' => 'InputEmail', 'placeholder' => 'Ваш E-mail', 'required' => 'true']) !!}
            </div>
            <div class="form-group py-2">
                {!! Form::text('phone', Request::old('phone'), ['class' => 'form-control rounded-0', 'id' => 'inputPhone', 'placeholder' => 'Ваш телефон',])!!}
            </div>
            <div class="form-group py-2">
                {!! Form::textarea('message', Request::old('message'), ['id' => 'editor', 'class' => 'form-control rounded-0', 'rows' => 4, 'placeholder' => 'Комментарии к заказу'])!!}
            </div>
            <div class="form-group">
                <div class="custom-file">
                    {!! Form::file('file', ['id' => 'customFile', 'class' => 'custom-file-input'])!!}
                    {!! Form::label('file', 'Выберите файл', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control mr-auto custom-checkbox">
                    {!! Form::checkbox('check', Request::old('check'), true , ['class' => 'custom-control-input form-check-input', 'id' => 'invalidCheck', 'required' => 'true'])!!}
                    {!! Html::decode(Form::label('invalidCheck', 'Нажимая кнопку «отправить», Вы даете согласие на <a href="/page/politika-konfidentsialnosti">обработку своих персональных данных</a>', ['class' => 'custom-control-label'])); !!}
                </div>
            </div>
            <button type="submit" class="btn form-control-lg rounded-0 green-btn">Сделать заказ</button>
        {{--{!! Form::close() !!}--}}
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js" integrity="sha256-HQCkPjsckBtmO60xeZs560g8/5v04DvOkyEo01zhSpo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function(){
        $("#inputPhone").inputmask("+7(999) 999-99-99");
        $('#customFile').on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#license-check').on('change',function() {
            if ($(this).prop('checked'))
                $(this).val($(this).prop('checked'));
            else $(this).val('');
        });

        $("#service_form").validate({
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
                $('#service_form').addClass('was-validated');
            },
            submitHandler: function(form) {
                var postData = new FormData();
                $.each(form, function(i, val) {
                    if (val.name === 'file'){
                        if (val.files[0] !== null){
                            postData.append(val.name, val.files[0]);
                        }
                    } else {
                        postData.append(val.name, val.value);
                    }
                });
                $.ajax({
                    url: '{{url('/service-form')}}' ,
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