@if ($checkService['product'])
<div class="col-xs-6 col-sm-6 col-md-6 col-lg">
    <div class="list-bottom">
        <div class="list-title">
            Продукция
        </div>
        <ul class="list-unstyled">
            @foreach ($checkService['product'] as $arService)
                <li><a href="{{url('service',['alias' => $arService->alias])}}">{{$arService->title}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if ($checkService['service'])
<div class="col-xs-6 col-sm-6 col-md-6 col-lg">
    <div class="list-bottom">
        <div class="list-title">
            Услуги
        </div>
        <ul class="list-unstyled">
            @foreach ($checkService['service'] as $arService)
                <li><a href="{{url('service', ['alias' => $arService->alias])}}">{{$arService->title}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<div class="col-xs-6 col-sm-6 col-md-6 col-lg">
    <div class="list-bottom">
        <div class="list-title">
            Документы и контакты
        </div>
        @if ($checkService['policy'])
            <ul class="list-unstyled policy-list">
                @foreach ($checkService['policy'] as $arPolicy)
                    <li><a href="{{ url('page', ['alias' => $arPolicy->alias]) }}">{{$arPolicy->title}}</a></li>
                @endforeach
            </ul>
        @endif
        <address itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="name">Типография «Элис Групп»</span><br>
            <span itemprop="addressLocality">Россия, Москва</span>,<br> <span itemprop="streetAddress">Семеновская Набережная,
                            д.3/1, корпус 6, подъезд 8, 1 этаж, оф. 1</span><br>
            <span itemprop="telephone">+7 (495) 902-77-23<br>
                +7 (999) 869-23-77<br></span>
            <a itemprop="email" href="mailto:info@alicegroup.ru">info@alicegroup.ru</a>
        </address>
    </div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg">
    <div class="list-bottom">
        <div class="t-sociallinks text-right">
            <div class="t-sociallinks__wrapper">
                <div class="t-sociallinks__item"><a href="https://www.facebook.com/Alicegroup.ru/"
                                                    target="_blank">
                        <svg class="t-sociallinks__svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve"><desc>Facebook</desc><path style="fill:#525252;" d="M21.1 7.8C22.5 6.5 24.5 6 26.4 6h6v6.3h-3.9c-.8-.1-1.6.6-1.8 1.4v4.2h5.7c-.1 2-.4 4.1-.7 6.1h-5v18h-7.4V24h-3.6v-6h3.6v-5.9c.1-1.7.7-3.3 1.8-4.3z"></path></svg>
                    </a></div>
                <div class="t-sociallinks__item"><a
                            href="https://www.youtube.com/channel/UCE6rQsrA5EgVODO5_8EYMnA" target="_blank">
                        <svg class="t-sociallinks__svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48" enable-background="new -455 257 48 48" xml:space="preserve"><desc>Youtube</desc><path style="fill:#525252;" d="M43.9 15.3c-.4-3.1-2.2-5-5.3-5.3-3.6-.3-11.4-.5-15-.5-7.3 0-10.6.2-14.1.5-3.3.3-4.8 1.8-5.4 4.9-.4 2.1-.6 4.1-.6 8.9 0 4.3.2 6.9.5 9.2.4 3.1 2.5 4.8 5.7 5.1 3.6.3 10.9.5 14.4.5s11.2-.2 14.7-.6c3.1-.4 4.6-2 5.1-5.1 0 0 .5-3.3.5-9.1 0-3.3-.2-6.4-.5-8.5zM19.7 29.8V18l11.2 5.8-11.2 6z"></path></svg>
                    </a></div>
                <div class="t-sociallinks__item"><a
                            href="https://www.instagram.com/alicegroup.ru/?hl=en" target="_blank">
                        <svg class="t-sociallinks__svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 25 25" enable-background="new 0 0 25 25" xml:space="preserve"><desc>Instagram</desc><path style="fill:#525252;" d="M16.396,3.312H8.604c-2.921,0-5.292,2.371-5.292,5.273v7.846c0,2.886,2.371,5.256,5.292,5.256h7.791c2.922,0,5.292-2.37,5.292-5.274V8.586C21.688,5.683,19.317,3.312,16.396,3.312L16.396,3.312z M7.722,12.5c0-2.64,2.142-4.778,4.778-4.778c2.636,0,4.777,2.138,4.777,4.778s-2.142,4.777-4.777,4.777C9.864,17.277,7.722,15.14,7.722,12.5zM17.756,8.182c-0.615,0-1.104-0.487-1.104-1.102s0.488-1.103,1.104-1.103c0.614,0,1.102,0.488,1.102,1.103S18.37,8.182,17.756,8.182L17.756,8.182z"></path><path style="fill:#525252;" d="M12.5,9.376c-1.731,0-3.124,1.398-3.124,3.124c0,1.725,1.393,3.124,3.124,3.124c1.732,0,3.124-1.399,3.124-3.124C15.624,10.775,14.211,9.376,12.5,9.376L12.5,9.376z"></path></svg>
                    </a></div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <span class="security-right" style="color: rgb(255, 134, 70);">* Все цены указанные на данном сайте, имеют информационный характер и не являются публичной офертой</span>
</div>