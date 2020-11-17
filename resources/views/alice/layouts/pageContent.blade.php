<div class="container">
    <div class="content mx-auto py-5">
       @if($page->text)
            {!! $page->text !!}
        @endif
    </div>
</div>

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
