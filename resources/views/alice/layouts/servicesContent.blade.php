@if ($services['data'])
<div class="container">
    <div class="content mx-auto py-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            @foreach($services['data'] as $item)
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-img-top">
                            <a href="{{route('service', $item->alias)}}">
                                @if(isset($item->image))
                                    {!! Html::image(Storage::url($item->image), $item->title) !!}
                                @endif
                            </a>
                        </div>
                        <div class="card-body">
                            {{--<p class="card-text"><small class="text-muted">{{($item->updated_at)? Date::parse($item->updated_at)->format('l, j F Y'): Date::parse($item->created_at)->format('l, j F Y') }}</small></p>--}}
                            <div class="card-title"><a href="{{route('service', $item->alias)}}">{{$item->title}}</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@include(env('THEME').'.layouts.serviceForm')
<div class="section bg-gray py-5">
    <div class="container">
        <h3 class="">Технические требования к макету</h3>
        <p class="lead">Перед тем, как направить нам макет, проверьте, верно ли Вы подготовили его для печати. Правильная допечатная подготовка экономит много времени.</p>
        <div class="row list-lead py-5">
            <div class="col-12 col-md-6">
                <ul class="list-unstyled">
                    <li>Форматы - pdf, tiff, Ai, SVG</li>
                    <li>Разрешение (для растра) - 300 dpi</li>
                    <li>Цветность - CMYK (100% black)</li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <ul class="list-unstyled">
                    <li>Вылеты - 5мм</li>
                    <li>Макет блока - постраничный вид</li>
                    <li>Макет обложки / переплета - разворотный вид
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <a class="tech-service" target="_blank" href="{{url('/images/tehtreb-конвертирован.pdf')}}">Технические требования <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-pdf" class="svg-inline--fa fa-file-pdf fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9 37.1 15.8 42.8 9 42.8 9z"></path></svg></a>
        </div>
    </div>
</div>
<div class="section py-5">
    <div class="container">
        <h3 class="">Виды выполняемых работ</h3>
        <p class="lead">«Элис Групп» — типография полного цикла. Мы можем подготовить макет
            к печати, отпечатать изделия и собрать их в готовую книжку.</p>
        <div id="accordion" class="cats py-5">
            @foreach($services['accordion'] as $key => $item)
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
<script type="text/javascript">
    $('#accordion').on('shown.bs.collapse', function(e){
        $('html, body').animate({
            scrollTop: $('#' + e.target.id).offset().top
        }, 1000);
    });
</script>