@props(['photo'])
<div class="form-group">
    <label for="profilePhoto">Profile Photo <span class="text-red">(Optional)</span></label>
    <div class=" d-flex justify-content-center">
        @if($photo)
            <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail img img-circle d-block mb-2" style="width: 100px" alt="">

        @else
            <img src="{{ $state['avatar_url'] ?? "" }}" class=" img img-circle d-block mb-2" style="width: 100px" alt="">

        @endif
    </div>
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
</div>
