<div class="container">
    <div class="content announce mx-auto py-5">
        <div itemtype="https://schema.org/Product" itemscope>
            <meta itemprop="name" content="{{$announce->title}}" />
            <link itemprop="image" href="{{ Storage::url($announce->images)}}" />
            <meta itemprop="description" content="{!!$announce->desc!!}" />
            <div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
                <link itemprop="url" href="{{ url(Request::url()) }}" />
                <meta itemprop="availability" content="https://schema.org/InStock" />
                <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
                <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                    <meta itemprop="name" content="alice group" />
                </div>
            </div>
        </div>
        <div class="detail-text">
            <div class="row">
                @if(isset($announce->image))
                    <div class="col-md-4 d-none d-md-block">
                        {!! Html::image(Storage::url($announce->image), $announce->title, ['class' => 'img-thumbnail float-right']) !!}
                    </div>
                @endif
                <div class="col-md-8">
                    <h1>{{$announce->title}}</h1>
                    <small>{{$announce->author['title']}}</small>
                    <div class="mt-4">{!!$announce->text!!}</div>
                </div>
            </div>
        </div>
    </div>
</div>