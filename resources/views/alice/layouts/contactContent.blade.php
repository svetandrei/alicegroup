<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=00b7118d-746e-4908-860a-d7da443e3f28" type="text/javascript"></script>
<script type="text/javascript">
    function init() {
        // Задаём точки мультимаршрута.
        var pointA = [55.782096, 37.705284],
            pointB = "Семёновская набережная, 3/1к6, подъезд 8",
            /**
             * Создаем мультимаршрут.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/multiRouter.MultiRoute.xml
             */
            multiRoute = new ymaps.multiRouter.MultiRoute({
                referencePoints: [
                    pointA,
                    pointB
                ],
                params: {
                    routingMode: 'pedestrian'
                }
            });


        // Создаем карту с добавленной на нее кнопкой.
        var myMap = new ymaps.Map('map', {
            center: [55.781002, 37.702400],
            zoom: 17,
        });

        if ($(window).width() <= '992'){
            myMap.setCenter(
                [55.781006, 37.705284],
                16
            );
        }
        if ($(window).width() <= '992' && $(window).width() >= '575'){
            myMap.behaviors.disable('drag');
        }

        myMap.geoObjects.add(multiRoute);
    }

    ymaps.ready(init);


</script>
<div id="map"></div>
<div class="card text-left py-4 shadow px-5">
    @if($page->text)
        {!! $page->text !!}
    @endif
</div>