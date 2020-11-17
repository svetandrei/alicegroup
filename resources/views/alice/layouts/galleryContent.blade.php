@if($gallery)
<div class="container-fluid">
    <div class="row gallery">
        @php
            $f = 1;
            $l = 3;
        @endphp
        @foreach($gallery as $key => $item)
        <div class="item {{ ($key >= $f && $key < $l)?'col-md-8':'col-md-4'}}" data-src="{{ Storage::url($item->image) }}" data-download-url="false">
            <a style="background: url('{{ Storage::url($item->image) }}') no-repeat scroll center center / cover;" href="javascript:void(0)" >
            </a>
        </div>

            @if($l == $key)
                @php
                    $f+=4;
                    $l+=4;
                @endphp
            @endif
        @endforeach
    </div>
</div>
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.css" integrity="sha256-LvrAcvFsV6d8qTupmF/43JY8J0gB1hKVs8Hm2rAlcHc=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js" integrity="sha256-w14QFJrxOYkUnF0hb8pVFCSgYcsF0hMIKrqGb8A7J8A=" crossorigin="anonymous"></script>                <script type="text/javascript">
    $(document).ready(function() {
        $(".gallery").lightGallery({
            selector: '.item',
            thumbnail: false,
            animateThumb: false,
            showThumbByDefault: false,
            autoplayControls: false,
            share: false,
            actualSize: false,
            fullScreen: false
        });
    });
</script>