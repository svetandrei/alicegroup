
    {!! Form::open(['class'=> 'contact-form my-4', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
    @method('PUT')
    <div class="form-group">
        <label for="files">Мультизагрузка изображений:</label>
        <div class="custom-file">
            {!! Form::file('files[]', ['id' => 'customFile', 'class' => 'custom-file-input', 'multiple'])!!}
            {!! Form::label('files', 'Выберите изображения', [ 'class'=>'custom-file-label', 'for' => 'customFile', 'data-browse' => 'Обзор'])!!}
        </div>
    </div>
    <div class="form-group">
        <div class="progress d-none">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="alert errors d-none" role="alert">
    </div>
    <div class="row text-center text-lg-left gallery my-4">
        @if ($galleries)
        @foreach($galleries as $gallery)
        <div class="col-lg-3 col-md-4 col-6" id="{{$gallery->id}}">
            <a href="javascript:void(0)" class="d-block mb-4 h-100">
                @if(isset($gallery->image))
                    <div class="image-wrapper img-thumbnail">
                        {!! Html::image(Storage::url($gallery->image), "", ['class' => 'img-fluid ']) !!}
                    </div>
                @endif
                    <div class="card-body d-flex">
                        <div class="custom-control mr-auto custom-checkbox">
                            {!! Form::checkbox('delete[]', $gallery->id, null, ['class' => 'custom-control-input check-input', 'id' => 'customCheck'.$gallery->id])!!}
                            {!! Form::label('customCheck'.$gallery->id, 'Выбрать',['class' => 'custom-control-label']); !!}
                        </div>
                        {!! Form::open(['url' => route('update_file',['id' => $gallery->id]), 'class'=> 'form-horizontal form-edit', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                            @if(isset($gallery->id))
                                @method('PUT')
                            @endif
                            <div class="btn btn-sm btn-primary edit-image btn-circle"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="edit" class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>
                                {!! Form::file('image', ['id' => 'editFile'.$gallery->id, 'class' => 'edit-file-input'])!!}
                            </div>
                            {{ Form::hidden('id_image', $gallery->id) }}
                        {!! Form::close() !!}
                        {!! Form::open(['url' => route('gallery.destroy', ['gallery' => $gallery->id]),'class'=> 'form-horizontal form-delete', 'method'=>'POST']) !!}
                            {{ Form::hidden('id_image', $gallery->id) }}
                            {!! Form::button('<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>', ['class' => 'btn btn-sm btn-danger delete-image btn-circle', 'type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </div>
            </a>
        </div>
        @endforeach
            @endif
    </div>
    <div class="form-group text-right">
        {!! Form::button('Удалить выбранные', ['class' => 'btn btn-sm btn-danger delete-all', 'type'=>'submit', 'disabled' => 'true']) !!}
    </div>


<script type="text/javascript">
    function num2str(n, textForms) {
        n = Math.abs(n) % 100; var n1 = n % 10;
        if (n > 10 && n < 20) { return textForms[2]; }
        if (n1 > 1 && n1 < 5) { return textForms[1]; }
        if (n1 == 1) { return textForms[0]; }
        return textForms[2];
    }
    $(function(){
        $(document).on('change', 'input.check-input', function(){
            var check = false;
            $('input.check-input').each(function(e, v){
                if(v.checked){
                    check = true;
                }
            });
            if (check) {
                $('.delete-all').attr('disabled', false);
            } else {$('.delete-all').attr('disabled', true);}
        });

        /**
         *  Delete selected images
         */
        $(document).on('click', '.delete-all', function(e){
            var imagesID = [];
            e.preventDefault();
            $('input.check-input').each(function(e, v){
                if(v.checked){
                    imagesID.push([$(this).val()]);
                }
            });
            if (imagesID) {
                var postData = new FormData();
                postData.append('imagesID[]', imagesID);
                $.ajax({
                    url: '{{route('delete_selected')}}',
                    type: "POST",
                    processData: false,
                    contentType : false,
                    headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                    data: postData,
                    success: function( response ) {
                        msg = JSON.parse(JSON.stringify(response));
                        $('.errors').removeClass('alert-danger alert-success').html('');

                        if (msg.messages){
                            if (Array.isArray(msg.messages)){
                                $.grep(msg.messages, function(el, arr) {
                                    $('.errors').append(el + '<br>').removeClass('d-none').addClass(msg.class);
                                });
                            } else {
                                $('.errors').append(msg.messages).removeClass('d-none').addClass(msg.class);
                            }
                        }
                    },
                    complete: function(){
                        if (msg.result){
                            if (Array.isArray(msg.result)){
                                msg.result.forEach(function(item, i, arr) {
                                    $('#' + item).remove();
                                });
                            }
                        }
                    }
                });
            }
        });

        /**
         * Delete image by ID
         */
        $(document).on('click', '.delete-image', function(e){
             e.preventDefault();
            var url = $(this).parents('form.form-delete').attr('action');
            $.ajax({
                url: url,
                type: "DELETE",
                processData: false,
                contentType : false,
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                success: function( response ) {
                    msg = JSON.parse(JSON.stringify(response));
                    $('.errors').removeClass('alert-danger alert-success').html('');

                    if (msg.messages){
                        if (Array.isArray(msg.messages)){
                            $.grep(msg.messages, function(el, arr) {
                                $('.errors').append(el + '<br>').removeClass('d-none').addClass(msg.class);
                            });
                        } else {
                            $('.errors').append(msg.messages).removeClass('d-none').addClass(msg.class);
                        }
                    }
                },
                complete: function(){
                    if (msg.result){ $('#'+ msg.result).remove();}
                }
            });
        });

        /**
         * Update image by ID
         */
        $(document).on('change', '.edit-file-input', function(e){
            e.preventDefault();
            var url = $(this).parents('form.form-edit').attr('action'),
            postData = new FormData();
            postData.append($(this)[0].name, $(this)[0].files[0]);
            $.ajax({
                url: url,
                type: "POST",
                processData: false,
                contentType : false,
                cache: false,
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                data: postData,
                success: function( response ) {
                    msg = JSON.parse(JSON.stringify(response));
                    $('.errors').removeClass('alert-danger alert-success').html('');
                    if (msg.messages){
                        if (Array.isArray(msg.messages)){
                            $.grep(msg.messages, function(el, arr) {
                                $('.errors').append(el + '<br>').removeClass('d-none').addClass(msg.class);
                            });
                        } else {
                            $('.errors').append(msg.messages).removeClass('d-none').addClass(msg.class);
                        }
                    }
                },
                complete: function(){
                    if (msg.result){ $('#' + msg.result.id).find('img').attr('src', 'http://' + location.hostname + '/storage/' + msg.result.image);}
                }
            });
        });

        /**
         * Upload images multiple
         */
        $('#customFile').on('change',function(e){
            e.preventDefault();
            var fileName = e.target.files.length;
            $(this).next('.custom-file-label').html(fileName + ' ' + num2str(fileName, ['файл', 'файла', 'файлов']));
            var postData = new FormData();
            $.each(e.target.files, function(i, val) {
                postData.append('files[]', val);
            });
            $.ajax({
                url: '{{route('gallery.store')}}',
                type: "POST",
                xhr: function()
                {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $('.progress-bar').css({
                                width: percentComplete * 100 + '%'
                            });
                        }
                    }, false);
                    xhr.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $('.progress-bar').css({
                                width: percentComplete * 100 + '%'
                            });
                        }
                    }, false);
                    return xhr;
                },
                processData: false,
                contentType : false,
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                data: postData,
                beforeSend: function( data ){
                    $('.progress').removeClass('d-none');
                },
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
                        }
                    }
                    if (msg.result){
                        $('.gallery').append(msg.result);
                    }
                },complete: function() {
                    $('.progress').addClass('d-none');
                    $('.custom-file-label').text('Выберите изображения');
                }
            });
        });

    });
</script>