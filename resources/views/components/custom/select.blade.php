@props(['id', 'view'=>false])
<div >
    <select id="{{ $id }}" name="{{ $id }}" class="form-control" wire:model.defer="state.{{ $id }}" @if($view) disabled @endif >
        {{ $slot }}
    </select>
</div>
