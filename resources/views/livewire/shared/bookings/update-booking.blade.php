<x-animation.ball-spin></x-animation.ball-spin>
<form autocomplete="off" wire:submit.prevent="updateBooking">
    <div class="card-body" >
        <div class="row">
            <input type="hidden" id="t_trip_fromlat" name="t_trip_fromlat" value="1">
            <input type="hidden" id="t_trip_fromlog" name="t_trip_fromlog" value="1">
            <input type="hidden" id="t_trip_tolat" name="t_trip_tolat" value="1">
            <input type="hidden" id="t_trip_tolog" name="t_trip_tolog" value="1">

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

        </div>
        <div class="row">
            <x-custom.input model="trip_start_date" :view="$viewMode" isAddBooking="true" isDate="true">Trip Start Date</x-custom.input>
            <x-custom.input model="trip_end_date" :view="$viewMode" isAddBooking="true" isDate="true">Trip End Date</x-custom.input>
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
        </div>
        <div class="row">
            <x-custom.input model="t_trip_start" customLabel="Trip start" :view="$viewMode"  isAddBooking="true" isOnChange="true">Trip Start Location</x-custom.input>
            <x-custom.input model="t_trip_end"  customLabel="Trip End" :view="$viewMode"  isAddBooking="true" isOnChange="true">Trip End Location</x-custom.input>
            <x-custom.input model="t_total_distance" customLabel="Total Distance" :view="$viewMode"  isAddBooking="true" isOnChange="true" dis="true">Approx Total KM</x-custom.input>
        </div>
    </div>
    <div class="card-footer justify-content-end d-flex">
        @if(!$viewMode)
            <button type="submit" class="btn customBg text-white"><i
                    class="fa fa-save mr-2"></i>{{ $isUpdate ? 'Save Changes' : 'Save' }}</button>
        @endif
    </div>
</form>
