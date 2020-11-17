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