<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\Settings;
use Livewire\WithFileUploads;


class ClientSettings extends Settings
{

    use WithFileUploads;
    public $image;

    public $state;


    public function mount(){
        $this->state = auth()->user()->only(['name', 'email']);
//        $this->state['api_key'] = Setting::where('id', 1)->pluck('api_key')->first();

    }

    public function render()
    {
        return view('livewire.client.client-settings');
    }
}
