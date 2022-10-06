<x-animation.ball-spin></x-animation.ball-spin>
{{--@dump($location)--}}
<div class="row">
    <div class="col-lg-12">
    </div>
</div>

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

        function loadMap() {
            let map;
            let bounds = new google.maps.LatLngBounds();
            let mapOptions = {
                mapTypeId: 'roadmap',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            map.setTilt(100);
            let infoWindowContent = [
               [
                   '<div class="info_content">' +
                   '<h4>title</h4></div>'
               ]
            ];
            // let markers = [
            //     ["name",8.44,124.66]
            // ];

            let markers = [
                @foreach($location as $loc)
               ['{{ $loc->id }}',  {{ $loc->latitude }},  {{ $loc->longitude }}, '{{ asset('images/2.png') }}']
                @endforeach
            ];

            // Add multiple markers to map
            let infoWindow = new google.maps.InfoWindow(), marker, i;


            // Place each marker on the map
            for( let i = 0; i < markers.length; i++ ) {
                let position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    icon: markers[i][3],
                    title: markers[i][0]
                });
                // Add info window to marker
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));



            }

            // Center the map to fit all markers on the screen
            map.fitBounds(bounds);

            // Set zoom level
            let boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
            });
        }


    </script>
@endpush
