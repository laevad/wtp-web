<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\Tracking;
use App\Models\ApiKey;

class ClientTracking extends Tracking
{
    public $role = 'client';

    public function render()
    {
        $apiKey = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();
        return view('livewire.client.client-tracking',[
            'apiKey' => $apiKey,
        ]);
    }
}
