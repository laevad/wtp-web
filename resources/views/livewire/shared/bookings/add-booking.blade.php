<x-animation.ball-spin></x-animation.ball-spin>

<a href="{{ route("$role.booking-list") }}" class="btn customBg text-white mb-2"><i class="fa fa-arrow-left mr-1">

    </i>Booking list</a>
<form autocomplete="off" wire:submit.prevent="{{ $isUpdate ? 'updateBooking' : 'createBooking' }}">
    <div class="card-body" >
        <div class="row">
            <input type="hidden" id="t_trip_fromlat" name="t_trip_fromlat" value="1" wire:ignore>
            <input type="hidden" id="t_trip_fromlog" name="t_trip_fromlog" value="1" wire:ignore>
            <input type="hidden" id="t_trip_tolat" name="t_trip_tolat" value="1" wire:ignore>
            <input type="hidden" id="t_trip_tolog" name="t_trip_tolog" value="1" wire:ignore>

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
{{--            <x-custom.input model="cargo_type" :view="$viewMode" isAddBooking="true" >Cargo Type</x-custom.input>--}}
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="gen_merch_id" class="form-label">General Merchandise @if(!$viewMode)<span class="text-red">*</span> @endif</label>
                    <div class="@error('gen_merch_id') is-invalid border  border-danger round custom-error @enderror">
                        <x-custom.select id="gen_merch_id" :view="$viewMode">
                            <option value="" readonly>Select Merchandise</option>
                            @foreach($gen_merch as $data)
                                <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
                            @endforeach
                        </x-custom.select>
                    </div>
                    @error('gen_merch_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
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
                <label for="t_trip_start">Origin <span class="text-red">*</span></label>
                <input type="text" wire:model.defer="state.t_trip_start" class="form-control
                @error('t_trip_start') is-invalid @enderror  " id="t_trip_start" placeholder="Origin"
                       onchange="this.dispatchEvent(new InputEvent('input'))"
                       wire:ignore wire:loading.attr="disabled"
                >
                @error('t_trip_start')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4" wire:ignore.self>
                <label for="t_trip_end">Destination <span class="text-red">*</span></label>
                <input type="text" wire:model.defer="state.t_trip_end"
                       class="form-control  @error('t_trip_end') is-invalid @enderror  "
                       id="t_trip_end" placeholder="Destination"
                       wire:ignore.self
                       onchange="this.dispatchEvent(new InputEvent('input'))"

                >
                @error('t_trip_end')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="t_total_distance">Total Distance (km) <span class="text-red">*</span></label>
                <input type="text" wire:model.defer="state.t_total_distance"
                       class="form-control @error('t_total_distance') is-invalid @enderror "
                       id="t_total_distance" placeholder="Total Distance"
                       onchange="this.dispatchEvent(new InputEvent('input'))"
                       wire:ignore
                >
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
            <button type="submit" class="btn customBg text-white" wire:loading.attr="disabled" ><i
                    class="fa fa-save mr-2"></i>{{ $isUpdate ? 'Save Changes' : 'Save' }}</button>
        @endif
    </div>
</form>
<x-custom.js.map :apiKey="$apiKey"/>
