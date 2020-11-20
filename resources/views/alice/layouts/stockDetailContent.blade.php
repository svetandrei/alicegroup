<div class="container">
    <div class="content announce mx-auto pb-5">
        <div itemtype="https://schema.org/Product" itemscope>
            <meta itemprop="name" content="{{$stock->title}}" />
            <link itemprop="image" href="{{ Storage::url($stock->images)}}" />
            <meta itemprop="description" content="{!!$stock->desc!!}" />
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
                @if(isset($stock->cover))
                    <div class="col-md-12">
                        {!! Html::image(Storage::url($stock->cover), $stock->title, ['class' => 'rounded-lg img-fluid']) !!}
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="mt-4">{!!$stock->text!!}</div>
                </div>
            </div>
        </div>
    </div>
</div>