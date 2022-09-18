@props(['isEdit'=>false, 'isView'=>false,])
<div class="modal fade " id="form" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <  <h5 class="modal-title" id="exampleModalLabel">{{ $isEdit ? 'Update Client':'Add New Client' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $isEdit ? 'updateVehicle' : 'createVehicle' }}"  >
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="d_id" id="d_id" value="" autocomplete="off">
                        <x-custom.input model="registration_number" :isView="$isView">Registration Number</x-custom.input>
                        <x-custom.input model="name" :isView="$isView">Vehicle Name</x-custom.input>
                        <x-custom.input model="model" :isView="$isView">Model</x-custom.input>
                        <x-custom.input model="chassis_no" :isView="$isView">Chassis No.</x-custom.input>
                        <x-custom.input model="engine_no" :isView="$isView">Engine No.</x-custom.input>
                        <x-custom.input model="manufactured_by" :isView="$isView">Manufactured By</x-custom.input>
                        <x-custom.input model="registration_expiry_date" :isView="$isView" isDate="true">Reg. Expiry Date</x-custom.input>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="d_is_active" class="form-label">Driver Status @if(!$isView)<span class="text-red">*</span> @endif</label>
                                <div class="@error('status') is-invalid border  border-danger round custom-error @enderror">
                                    <x-custom.select id="status" :view="$isView">
                                        <option value="">Select Driver Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </x-custom.select>
                                </div>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times mr-2"></i>{{ $isEdit ? 'Close' : 'Cancel' }}</button>
                    @if(!$isView) <button type="submit" class="btn customBg text-white"><i class="fa fa-save mr-2"></i>{{ $isEdit ? 'Save Changes' : 'Save' }}</button> @endif
                </div>
            </form>
        </div>
    </div>
</div>

