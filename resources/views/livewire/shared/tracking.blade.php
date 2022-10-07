<div id="m-container">
    <div id="map"></div>
</div>

@push('css')
    <style>
        #m-container {
            height: 450px;
        }
        #map {
            width: 100%;
            height: 100%;
            border: 2px solid #f76440;
        }
        #data, #allData {
            display: none;
        }
    </style>
@endpush

@push('js')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIv9nK_pTbE3bZi_nXJBCEg2dmSiEyq4E&callback=loadMap"></script>
    <script>
        let map;
        function loadMap() {
            const pune = {lat: 8.44, lng: 124.66};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: pune,
                mapTypeId: 'roadmap',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            });
        }
    </script>
@endpush
