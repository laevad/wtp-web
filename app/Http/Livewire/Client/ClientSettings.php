<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\Settings;
use Livewire\WithFileUploads;


class ClientSettings extends Settings
{


    public function render()
    {
        return view('livewire.client.client-settings');
    }
}
