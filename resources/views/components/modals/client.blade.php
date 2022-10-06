@props(['isEdit', 'photo'])
<div class="modal fade" id="form" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $isEdit ? 'Update Client':'Add New Client' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $isEdit ? 'updateUser' : 'createUser' }}" >
                <div class="modal-body">
                    {{--custom input--}}
                    <div class="row">
                        <x-custom.input model="name" isClient="true"></x-custom.input>
                        <x-custom.input model="email" isClient="true"></x-custom.input>
                        <x-custom.input model="mobile" isClient="true"></x-custom.input>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="d_is_active" class="form-label">Client Status <span class="text-red">*</span></label>
                                <div class="@error('status_id') is-invalid border  border-danger round  @enderror">
                                    <x-custom.select id="status_id" :view="false">
                                        <option value="">Select Driver Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </x-custom.select>
                                </div>
                                @error('status_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{--custom display picture--}}
                    <x-custom.profile-photo :photo="$photo"></x-custom.profile-photo>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times mr-2"></i>Cancel</button>
                    <button type="submit" class="btn customBg text-white"><i class="fa fa-save mr-2"></i>{{ $isEdit ? 'Save Changes' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
