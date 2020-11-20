<div class="container">
    @if ($stocks)
    <div class="content stock mx-auto pb-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
            @foreach($stocks as $item)
            <div class="col mb-4">
                <div class="card h-100">
                    <div class="card-img-top">
                        <a href="{{route('stock', $item->alias)}}">
                            <img src="{{Storage::url($item->image)}}" alt="{{$item->title}}" class="rounded-lg">
                        </a>
                    </div>
                    <div class="card-body">
                        {{--<p class="card-text"><small class="text-muted">{{($item->updated_at)? Date::parse($item->updated_at)->format('l, j F Y'): Date::parse($item->created_at)->format('l, j F Y') }}</small></p>--}}
                        <h5 class="card-title">
                            <a href="{{route('stock', $item->alias)}}">{{$item->title}}</a>
                        </h5>
                        <div class="card-text">{!!$item->desc!!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>