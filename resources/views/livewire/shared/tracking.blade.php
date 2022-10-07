
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


            let startPoint = {lat: {{ $fromLatitude }}, lng: {{ $fromLongitude }}};
            let endPoint = {lat: {{ $toLatitude }}, lng: {{ $toLongitude }}};

            let   directionsService = new google.maps.DirectionsService;
            let directionsDisplay = new google.maps.DirectionsRenderer;

            let mapOptions = {
                mapTypeId: 'roadmap',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            map.setTilt(100);


            directionsService.route({
                origin:startPoint,
                destination: endPoint,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });



            directionsDisplay.setMap(map);
        }
    </script>
@endpush
