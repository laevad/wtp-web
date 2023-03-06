<x-animation.ball-spin></x-animation.ball-spin>
<div id="m-container">
   <div class="form-group">
        <span class="description-header mr-2">Trip Status: <span class="badge badge-{{ $booking->status_type_badge }}">{{ $booking->status->name }}</span>
                                             </span>
   </div>
    <div id="map"></div>

    <div class="row col-md-6 mt-2 mx-auto">
        <button wire:click="$emit('refreshComponent')"  class="btn btn-primary form-control">Reload</button>
    </div>
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

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=loadMap"></script>
    <script>
        let map;
        let totalDistance;

        function loadMap() {


            let startPoint = {lat: {{ $fromLatitude }}, lng: {{ $fromLongitude }}};
            let endPoint = {lat: {{ $toLatitude }}, lng: {{ $toLongitude }}};

            let   directionsService = new google.maps.DirectionsService;
            let directionsDisplay = new google.maps.DirectionsRenderer;

            let mapOptions = {
                mapTypeId: 'roadmap',
                streetViewControl: true,
                fullscreenControl: true,
                mapTypeControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            map.setTilt(100);


            directionsService.route({
                origin: startPoint,
                destination: endPoint,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    var distance = response.routes[0].legs[0].distance.value / 1000; // distance in km
                    var distanceOverlay = new google.maps.OverlayView();
                    distanceOverlay.onAdd = function() {
                        var div = document.createElement('div');
                        div.style.border = 'none';
                        div.style.borderWidth = '0px';
                        div.style.position = 'absolute';
                        div.style.top = '10px';
                        div.style.left = '10px';
                        div.style.padding = '10px';
                        div.style.backgroundColor = 'white';
                        div.innerHTML = 'Total distance: ' + distance + ' km';
                        this.getPanes().floatPane.appendChild(div);
                    };
                    distanceOverlay.draw = function() {};
                    distanceOverlay.setMap(directionsDisplay.getMap());
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });



            let markers = [
                    @foreach($markers as $m)
                [{{ $m->latitude }}, {{ $m->longitude }}, '{{ asset('images/map/index.png') }}'],
                    @endforeach
                    @if($bookingStatus ==3)
                    @foreach($currentLocation as $cur)
                [{{ $cur->latitude }}, {{ $cur->longitude }}, '{{ asset('images/map/2.png') }}'],
                @endforeach
                @endif

            ];



            // Place each marker on the map
            for( let i = 0; i < markers.length; i++ ) {
                let position = new google.maps.LatLng(markers[i][0], markers[i][1]);
                marker = new google.maps.Marker({

                    position: position,
                    map: map,
                    icon: markers[i][2],
                    title: 'Drop',
                    animation: google.maps.Animation.DROP,
                });
            }




            directionsDisplay.setMap(map);
        }
    </script>
@endpush
