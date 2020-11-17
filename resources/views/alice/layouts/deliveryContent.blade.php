@if($delivery)
<div class="container">
    <div class="content mx-auto py-5">
        @foreach($delivery as $key => $item)
        <div class="block my-5 d-flex align-items-center mx-auto {{ ($key%2==0)?'c-right':'' }}">
            <div class="left">
                <div class="left-content">
                    <div class="card-title">{{ $item->title }}</div>
                    {!! $item->desc !!}
                </div>
            </div>
            <div class="width-img">
                <img src="https://thumb.tildacdn.com/tild6430-6433-4263-b863-316261636234/-/cover/720x468/center/center/-/format/webp/iStock-812694096-150.jpg" class="card-img-top" alt="...">
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
