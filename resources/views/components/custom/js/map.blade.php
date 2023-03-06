@push('js')
    <script !src="">
        /*disable t_total_distance*/
        $('#t_total_distance').attr('disabled', true);
    </script>i
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key={{ $apiKey }}&libraries=drawing&libraries=places,drawing"></script>

    <script>
        (function($){
            'use strict';
            window.addEventListener('load', (event) => {
                /*disable id t_trip_end */
                $('#t_trip_end').attr('disabled', true);

                var googleplaces = new google.maps.places.Autocomplete(document.getElementById('t_trip_start'));
                /*on change t_trip_start*/
                $("#t_trip_start").on('change', function(){
                    /*clear the trip end*/
                    $('#t_trip_end').val('');
                    /*clear the total distance*/
                    $('#t_total_distance').val(0);
                    /*if empty disable trip_end*/
                    if($('#t_trip_start').val() == ''){
                        $('#t_trip_end').attr('disabled', true);
                    }
                });

                google.maps.event.addListener(googleplaces, 'place_changed', function () {
                    var place = googleplaces.getPlace();
                    var latitudes = place.geometry.location.lat();

                    var longitudes = place.geometry.location.lng();
                    document.getElementById("t_trip_fromlat").value = latitudes;
                    document.getElementById("t_trip_fromlog").value = longitudes;
                    /*log test*/
                    console.log(latitudes, longitudes);
                    /*enable trip_end*/
                    $('#t_trip_end').attr('disabled', false);

                });

                var places = new google.maps.places.Autocomplete(document.getElementById('t_trip_end'));

                var  latitude;
                var  longitude;
                google.maps.event.addListener(places, 'place_changed', function () {




                    var toplace = places.getPlace();
                    latitude = toplace.geometry.location.lat();
                    longitude = toplace.geometry.location.lng();
                    document.getElementById("t_trip_tolat").value = latitude;
                    document.getElementById("t_trip_tolog").value = longitude;

                    /*log test*/
                    console.log(latitude, longitude);

                    distance(document.getElementById("t_trip_fromlat").value, document.getElementById("t_trip_fromlog").value, latitude, longitude, 'K');


                });

                Livewire.emit('t_lat_long', latitude, longitude);
            });
            function distance(lat1, lon1, lat2, lon2, unit) {
                if ((lat1 === lat2) && (lon1 === lon2)) {
                    return 0;
                }
                else {
                    console.log(lat1, lon1, lat2, lon2);
                    /* 2 decimal places*/
                    let start = new google.maps.LatLng(lat1,lon1);
                    let end = new google.maps.LatLng(lat2,lon2);

                    calculateDistance(start, end, function(distance) {
                        if (distance !== null) {
                            document.getElementById("t_total_distance").value = distance.toFixed(2);
                            console.log('Distance: ' + distance + ' km');
                            $('#t_trip_end').attr('disabled', true);
                            // Livewire.emit('total_distance',  Math.round(dist),lat1, lon1, lat2, lon2);
                            Livewire.emit('total_distance',  distance.toFixed(2), lat1, lon1, lat2, lon2);
                        }
                    });
                }
            }
            $('#t_trip_end').attr('disabled', true);

            function calculateDistance(start, end, callback) {
                let directionsService = new google.maps.DirectionsService();

                directionsService.route({
                    origin: start,
                    destination: end,
                    travelMode: 'DRIVING'
                }, function(response, status) {
                    if (status === 'OK') {
                        let distance = response.routes[0].legs[0].distance.value / 1000; // in km
                        callback(distance);
                    } else {
                        console.error('Directions request failed due to ' + status);
                        callback(null);
                    }
                });
            }


        })(jQuery);
    </script>
@endpush
