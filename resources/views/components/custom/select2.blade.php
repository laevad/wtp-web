@props(['id'=>'', 'view'=>false, 'label'=>'', 'selectLabel'=>'', 'datas'=>[], 'isJs'=>false,'isAll'=>false])

<label for="{{ $id }}" class="form-label">{{ $label }} @if(!$view)<span class="text-red">*</span> @endif</label>
<div class="@error($id) is-invalid border  border-danger rounded custom-error @enderror">
    <div class="" wire:ignore>
        <div class="" wire:ignore>
            <select class="form-control select2bs4 select2-hidden-accessible select2" id="{{ $id }}"  name="{{ $id }}" style="width: 100%;" wire:loading.attr="disabled" wire:model.defer="state.{{ $id }}"  >
                @if($isAll)
                    <option value="all" readonly>All</option>
                @else
                    <option value="" readonly>{{ $selectLabel }}</option>
                @endif
                @foreach($datas as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@error($id)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror

@if(!$isJs)
    @push('js')
        <script>

            $('#{{ $id }}').on('select2:select', function (e) {
                var data = e.params.data;
            @this.set('state.{{ $id }}', data['id']);
            });
        </script>
    @endpush

@endif
