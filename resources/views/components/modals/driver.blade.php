    @props(['isEdit'=>false, 'isView'=>false, 'photo', 'state'])
<div class="modal fade " id="form" tabindex="-1" role="dialog" data-backdrop="static"
     aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">{{ $isEdit  ? 'Update Driver': ($isView? 'Driver details' : 'Add New Client') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $isEdit ? 'updateUser' : 'createUser' }}">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="d_id" id="d_id" value="" autocomplete="off">
                        <x-custom.input model="name" :isView="$isView"></x-custom.input>
                        <x-custom.input model="email" :isView="$isView"></x-custom.input>
                        <x-custom.input model="mobile" :isView="$isView"></x-custom.input>
                        <x-custom.input model="age" :isView="$isView"></x-custom.input>
                        <x-custom.input model="license_number" :isView="$isView"></x-custom.input>
                        <x-custom.input model="license_expiry_date" isDate="true" :isView="$isView"></x-custom.input>
                        <x-custom.input model="date_of_joining" isDate="true" :isView="$isView"></x-custom.input>
                        <x-custom.input model="total_experience" :isView="$isView"></x-custom.input>
                        <div class="p-2">
                            <div class="form-group">
                                <label for="d_is_active" class="form-label">Driver Status @if(!$isView)<span class="text-red">*</span> @endif</label>
                                <div class="@error('status_id') is-invalid border  border-danger round  @enderror">
                                    <x-custom.select id="status_id" :view="$isView">
                                        <option value="">Select Driver Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </x-custom.select>
                                </div>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address @if(!$isView)<span class="text-red">(Optional)</span></label>@endif
                                <textarea class="form-control" @if($isView) disabled @endif autocomplete="off"
                                          placeholder="Address" name="d_address" wire:model.defer="state.address"
                                          style="resize: none"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="profilePhoto">Profile Photo @if(!$isView) <span class="text-red">(Optional)</span>@endif</label>
                                @if(!$isView)
                                    <div class="custom-file">
                                        <div class="" x-data="{ isUploading: false, progress: 0 }"
                                             x-on:livewire-upload-start="isUploading= true"
                                             x-on:livewire-upload-finish="isUploading= false"
                                             x-on:livewire-upload-error="isUploading= false"
                                             x-on:livewire-upload-progress="progress = $event.detail.progress"
                                        >
                                            <input type="file" class="custom-file-input" id="profilePhoto" wire:model="photo">
                                            <div x-show="isUploading" class="progress progress-sm mt-2 rounded">
                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="custom-file-label" for="customFile">
                                            @if($photo)
                                                {{ $photo->getClientOriginalName() }}
                                            @else
                                                Choose Image
                                            @endif
                                        </label>
                                    </div>
                                @endif
                                <div class=" d-flex justify-content-center mt-2">
                                    @if($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail img img-circle d-block mb-2" style="width: 100px" alt="">

                                    @else
                                        <img src="{{ $state['avatar_url'] ??'' }}" class=" img img-circle d-block mb-2" style="width: 100px" alt="">

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i
                            class="fa fa-times mr-2"></i>{{ $isView ? 'Close' : 'Cancel' }}</button>
                    @if(!$isView)
                        <button type="submit" class="btn customBg text-white"><i
                                class="fa fa-save mr-2"></i>{{ $isEdit ? 'Save Changes' : 'Save' }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

