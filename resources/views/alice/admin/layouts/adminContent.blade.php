<div class="card-group justify-content-center">
@if($dashboard)
    @foreach($dashboard->items as $key => $item)
            @if (!$item->hasParent())
                <div class="col-md-4">
                    <div class="card bg-light mb-3" href="{{$item->url()}}">
                        <a class="card-header" href="{{ $item->url() }}">{!! $item->title !!}</a>
            @endif
            @if ($item->hasChildren())
                @include(env('THEME').'.admin.layouts.childAdminMenu', ['subItems' => $item->children()])
            @endif
                @if (!$item->hasParent())
                    </div>
                </div>
            @endif
    @endforeach

@endif
