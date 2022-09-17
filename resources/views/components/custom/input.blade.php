@props(['isPass'=>false, 'model', 'placeholder'=>''])
<div class="form-group">
    <label for="{{ $model }}">{{  ucfirst($model) }} <span class="text-red">*</span></label>
    <input type="{{$isPass? 'password' : 'text' }}" wire:model.defer="state.{{ $model }}" class="form-control @error($model) is-invalid @enderror" id="{{ $model }}" placeholder="Enter {{  ucfirst($model) }}">
    @error($model)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
