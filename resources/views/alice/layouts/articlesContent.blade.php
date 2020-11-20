@if (isset($data['announces']))
<script src="{{ asset(env('THEME').'/js/owl.carousel.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset(env('THEME').'/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset(env('THEME').'/css/owl.carousel.min.css') }}">
<div class="content d-flex justify-content-center cover pt-4 announces">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="w-100">
                    <div id="carousel" class="owl-carousel owl-theme owl-loaded owl-drag">
                        @foreach ($data['announces'] as $key => $item)
                            <div>
                                <div class="card">
                                    <a href="{{route('announce', $item->alias)}}">
                                        {!! Html::image(Storage::url($item->image), $item->title) !!}
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->title }}</h5>
                                            <p class="card-text"><small class="text-muted">{{ $item->author['title'] }}</small></p>
                                        </div>
                                        <button type="button" class="btn btn-light">Подробнее</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="container">
    @if ($data['categories'])
    <div class="content mx-auto py-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
            @foreach($data['categories'] as $item)
            <div class="col mb-4">
                <div class="card h-100">
                    <div class="card-img-top">
                        <a href="{{($item->url)?$item->url:route('category', $item->alias)}}">
                            <img src="{{Storage::url($item->image)}}" alt="{{$item->title}}">
                        </a>
                    </div>
                    <div class="card-body">
                        {{--<p class="card-text"><small class="text-muted">{{($item->updated_at)? Date::parse($item->updated_at)->format('l, j F Y'): Date::parse($item->created_at)->format('l, j F Y') }}</small></p>--}}
                        <h5 class="card-title">
                            @if ($item->url)
                                <a href="{{$item->url}}">{{$item->title}}</a>
                            @else
                                <a href="{{route('category', $item->alias)}}">{{$item->title}}</a>
                            @endif

                        </h5>
                        <div class="card-text">{!!$item->desc!!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @if ($data['articles'])
        <div class="content mx-auto py-5">
            @foreach($data['articles'] as $key => $item)
                <div class="block py-5 d-flex align-items-center mx-auto flex-wrap flex-md-nowrap {{ ($key%2==0)?'c-right':'' }}">
                    <div class="left">
                        <div class="left-content">
                            @if ($item->url)
                                <div class="card-title"><a href="{{$item->url}}">{{$item->title}}</a></div>
                            @else
                                <div class="card-title">{{ $item->title }}</div>
                            @endif
                            <div class="card-text">{!! $item->desc !!}</div>
                        </div>
                    </div>
                    <div class="width-img">
                        @if ($item->url)
                            <a href="{{$item->url}}">
                                <img src="{{Storage::url($item->image)}}" alt="{{ $item->title }}">
                            </a>
                        @else
                            <img src="{{Storage::url($item->image)}}" alt="{{ $item->title }}">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script type="text/javascript">
    $('#carousel').owlCarousel({
        lazyLoad: true,
        margin:30,
        dots: false,
        nav: true,
        autoplay: true,
        responsive:{
            0:{
                items:2,
                nav:false,
                dots: true
            },
            600:{
                items:3,
                nav:true
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });
</script>