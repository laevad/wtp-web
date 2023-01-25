@props(['isPass'=>false, 'model', 'placeholder'=>'', 'isView'=>false, 'isDate'=>false, 'isClient'=>false,
'isAddBooking'=>false, 'customLabel'=>null, 'isRequired' => true])

<div class="{{ $isClient? 'col-md-12' : ($isAddBooking? 'col-md-4': 'col-md-3') }}">
    <div class="form-group">
        <label for="{{ $model }}">{{ $customLabel == null?  ucfirst(str_replace("_", ' ', $model)) : $customLabel }} @if($isRequired) <span class="text-red">*</span> @endif</label>
        <input
            type="{{$isPass? 'password' : 'text' }}"
            wire:model.defer="state.{{ $model }}"
            wire:loading.attr="disabled"
            class="form-control @error($model) is-invalid @enderror @if($isDate)  datetimepicker-input @endif" id="{{ $model }}"
            placeholder="{{ $customLabel == null?  ucfirst(str_replace("_", ' ', $model)) : $customLabel }}"
            {{ $isView? 'disabled' : '' }}
            @if($isDate)
                onchange="this.dispatchEvent(new InputEvent('input'))"
            data-toggle="datetimepicker"
            @endif
            @if($isAddBooking)
                onchange="this.dispatchEvent(new InputEvent('input'))"

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
