<x-animation.ball-spin></x-animation.ball-spin>
{{--@dump($location)--}}
<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Vehicle's</span>
                <span class="info-box-number">{{ $totalVehicle }}  </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user-secret"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Drivers</span>
                <span class="info-box-number">{{ $totalDriver }} </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-user text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Client</span>
                <span class="info-box-number">{{ $totalClient }} </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- /.col -->
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
            const pune = {lat: 8.44, lng: 124.66};
            let map;
            let bounds = new google.maps.LatLngBounds();
            let mapOptions = {
                mapTypeId: 'roadmap',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                @if(count($location)==0)
                center: pune,
                zoom: 7,
                @endif
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            map.setTilt(100);
            let infoWindowContent = [
                    @foreach($location as $loc)
                [
                    '<div class="info_content">' +
                    '<h5>{{ $loc->user->name }}</h5></div>'
                ],
                @endforeach

            ];
            // let markers = [
            //     ["name",8.44,124.66]
            // ];

            let markers = [
                    @foreach($location as $loc)
                ['{{ $loc->user->name }}',  {{ $loc->latitude }},  {{ $loc->longitude }}, '{{ asset('images/2.png') }}'],
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

            @if(count($location)!=0)
            map.fitBounds(bounds);
            // Set zoom level
            let boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
            });
            @endif
        }

    </script>
@endpush
