@if ($subItems)
    <div class="card-body">
    @foreach ($subItems as $subItem)
        <p class="card-text"><a href="{{$subItem->url() }}">{!! $subItem->title !!}</a></p>
    @endforeach
    </div>
@endif