<x-animation.ball-spin></x-animation.ball-spin>
<a href="{{ route("$role.booking-list") }}" class="btn customBg text-white mb-2"><i class="fa fa-arrow-left mr-1"></i>Booking list</a>
<form autocomplete="off" wire:submit.prevent="updateBooking">
    <div class="card-body" >
        <div class="row">
            <input type="hidden" id="t_trip_fromlat" name="t_trip_fromlat" value="1">
            <input type="hidden" id="t_trip_fromlog" name="t_trip_fromlog" value="1">
            <input type="hidden" id="t_trip_tolat" name="t_trip_tolat" value="1">
            <input type="hidden" id="t_trip_tolog" name="t_trip_tolog" value="1">

            @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                <div class="col-md-4" >
                    <div class="form-group">
                        <x-custom.select2 id="user_id" label="Client" selectLabel="Select Client" :datas="$clients"></x-custom.select2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-custom.select2 id="vehicle_id" label="Vehicle" selectLabel="Select Vehicle" :datas="$vehicles"></x-custom.select2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-custom.select2 id="driver_id" label="Driver" selectLabel="Select Vehicle" :datas="$drivers"></x-custom.select2>
                    </div>
                </div>
            @endif

        </div>
        <div class="row">
            <x-custom.input model="trip_start_date" :view="$viewMode" isAddBooking="true" isDate="true">Trip Start Date</x-custom.input>
            <x-custom.input model="trip_end_date" :view="$viewMode" isAddBooking="true" isDate="true">Trip End Date</x-custom.input>
           @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                <div class="col-md-4" >
                    <div class="form-group">
                        <label for="trip_status_id" class="form-label">Trip Status @if(!$viewMode)<span class="text-red">*</span> @endif</label>
                        <div class="@error('trip_status_id') is-invalid border  border-danger round custom-error @enderror">
                            <x-custom.select id="trip_status_id" :view="$viewMode">
                                <option value="" readonly>Select Trip Status</option>
                                @foreach($trip_status as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </x-custom.select>
                        </div>
                        @error('trip_status_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="form-group col-md-4" wire:ignore.self>
                <label for="t_trip_start">Trip start <span class="text-red">*</span></label>
                <input type="text" wire:model="state.t_trip_start" class="form-control
                @error('t_trip_start') is-invalid @enderror  " id="t_trip_start" placeholder="Trip start"
                       onchange="this.dispatchEvent(new InputEvent('input'))">
                @error('t_trip_start')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4" wire:ignore.self>
                <label for="t_trip_end">Trip end <span class="text-red">*</span></label>
                <input type="text" wire:model.defer="state.t_trip_end" class="form-control  @error('t_trip_end') is-invalid @enderror  " id="t_trip_end" placeholder="Trip end" onchange="this.dispatchEvent(new InputEvent('input'))">
                @error('t_trip_end')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="t_total_distance">Total Distance <span class="text-red">*</span></label>
                <input type="text" wire:model.defer="state.t_total_distance" class="form-control @error('t_total_distance') is-invalid @enderror " id="t_total_distance" placeholder="Total Distance" onchange="this.dispatchEvent(new InputEvent('input'))" >
                @error('t_total_distance')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer justify-content-end d-flex">
        @if(!$viewMode)
            <button type="submit" class="btn customBg text-white" @if(!$disable) disabled @endif><i
                    class="fa fa-save mr-2"></i>{{ $isUpdate ? 'Save Changes' : 'Save' }}</button>
        @endif
    </div>
</form>

@push('js')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key={{ $apiKey }}&libraries=drawing&libraries=places,drawing"></script>

    <script>
        (function($){
            'use strict';
            window.addEventListener('load', (event) => {
                var googleplaces = new google.maps.places.Autocomplete(document.getElementById('t_trip_start'));
                google.maps.event.addListener(googleplaces, 'place_changed', function () {
                    var place = googleplaces.getPlace();
                    var latitudes = place.geometry.location.lat();
                    var longitudes = place.geometry.location.lng();
                    document.getElementById("t_trip_fromlat").value = latitudes;
                    document.getElementById("t_trip_fromlog").value = longitudes;

                });
                var places = new google.maps.places.Autocomplete(document.getElementById('t_trip_end'));
                google.maps.event.addListener(places, 'place_changed', function () {
                    var toplace = places.getPlace();
                    var latitude = toplace.geometry.location.lat();
                    var longitude = toplace.geometry.location.lng();
                    document.getElementById("t_trip_tolat").value = latitude;
                    document.getElementById("t_trip_tolog").value = longitude;
                    Livewire.emit('t_lat_long', latitude, longitude);
                    distance(document.getElementById("t_trip_fromlat").value, document.getElementById("t_trip_fromlog").value, latitude, longitude, 'K');
                });
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
                    Livewire.emit('total_distance',  Math.round(dist),lat1, lon1, lat2, lon2);
                    // document.getElementById("t_total_distance").value =  Math.round(dist);

                }
            }
        })(jQuery);
    </script>
@endpush
