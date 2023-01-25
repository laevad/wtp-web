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

                    distance(document.getElementById("t_trip_fromlat").value, document.getElementById("t_trip_fromlog").value, latitude, longitude, 'K');


                });

                Livewire.emit('t_lat_long', latitude, longitude);
            });
            function distance(lat1, lon1, lat2, lon2, unit) {
                if ((lat1 === lat2) && (lon1 === lon2)) {
                    return 0;
                }
                else {
                    var radlat1 = Math.PI * lat1/180;
                    var radlat2 = Math.PI * lat2/180;
                    var theta = lon1-lon2;
                    var radtheta = Math.PI * theta/180;
                    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                    if (dist > 1) {
                        dist = 1;
                    }
                    dist = Math.acos(dist);
                    dist = dist * 180/Math.PI;
                    dist = dist * 60 * 1.1515;
                    if (unit==="K") { dist = dist * 1.609344 }
                    if (unit==="N") { dist = dist * 0.8684 }
                    document.getElementById("t_total_distance").value =  Math.round(dist);
                    console.log(lat1, lon1, lat2, lon2);
                    console.log(dist);
                    console.log( Math.round(dist),lat1, lon1, lat2, lon2);
                    $('#t_trip_end').attr('disabled', true);
                    Livewire.emit('total_distance',  Math.round(dist),lat1, lon1, lat2, lon2);
                    // document.getElementById("t_total_distance").value =  Math.round(dist);
                }
            }
            $('#t_trip_end').attr('disabled', true);
        })(jQuery);
    </script>
@endpush
