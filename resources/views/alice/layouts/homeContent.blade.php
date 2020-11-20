{!! $home->text !!}
@if ($services)
    <div class="container">
        <div class="content mx-auto py-5 home-services">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                @foreach($services as $item)
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

@if ($gallery)
<script src="{{ asset(env('THEME').'/js/owl.carousel.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset(env('THEME').'/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset(env('THEME').'/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.css" integrity="sha256-LvrAcvFsV6d8qTupmF/43JY8J0gB1hKVs8Hm2rAlcHc=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js" integrity="sha256-w14QFJrxOYkUnF0hb8pVFCSgYcsF0hMIKrqGb8A7J8A=" crossorigin="anonymous"></script>
<div class="container our-work">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="heading text-center py-5">
                <h2>Наши работы</h2>
                <div class="lead">
                    <p>Следите за нашей лентой в Instagram. Мы публикуем информацию о свежих работах и новости.</p>
                </div>
            </div>

            <div class="carousel-inner w-100">
                <div id="carousel" class="owl-carousel owl-theme owl-loaded owl-drag">
                    @foreach ($gallery as $key => $item)
                        <div class="item" data-src="{{ Storage::url($item->image) }}" data-download-url="false">
                            {!! Html::image(Storage::url($item->image), "", ['class' => 'img-fluid']) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $('#carousel').owlCarousel({
            lazyLoad: true,
            margin:10,
            dots: true,
            autoplay: true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:2,
                    nav:false
                },
                1000:{
                    items:3,
                    nav:true,
                    loop:false
                }
            }
        });
        $("#carousel").lightGallery({
            selector: '.item',
            thumbnail: false,
            animateThumb: false,
            showThumbByDefault: false,
            autoplayControls: false,
            share: false,
            actualSize: false,
            fullScreen: false
        });
    </script>
@endif

<div class="bg-start">
    <div class="container">
        <div class="content mx-auto py-5">
            <div class="heading text-center py-5">
                <h2>С чего начать</h2>
                <div class="lead">
                    <p>6 этапов от идеи издания Вашего проекта, до книги в руках Вашего читателя</p>
                </div>
            </div>
            {!! $page->text !!}
        </div>
    </div>
</div>