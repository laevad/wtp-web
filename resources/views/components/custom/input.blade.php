@props(['isPass'=>false, 'model', 'placeholder'=>'', 'isView'=>false, 'isDate'=>false, 'isClient'=>false])

<div class="{{ $isClient? 'col-md-12' : 'col-md-3' }}">
    <div class="form-group">
        <label for="{{ $model }}">{{  ucfirst(str_replace("_", ' ', $model)) }} <span class="text-red">*</span></label>
        <input
            type="{{$isPass? 'password' : 'text' }}"
            wire:model.defer="state.{{ $model }}"
            class="form-control @error($model) is-invalid @enderror @if($isDate)  datetimepicker-input @endif" id="{{ $model }}"
            placeholder="{{  ucfirst(str_replace("_", ' ', $model)) }}"
            {{ $isView? 'disabled' : '' }}
            @if($isDate)
                onchange="this.dispatchEvent(new InputEvent('input'))"
            data-toggle="datetimepicker"
            @endif
        >
        @error($model)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
@if($isDate)
    @push('js')

        <script>
            $('#{{ $model }}').datetimepicker({
                format: 'L',
            });

        </script>
    @endpush

@endif
