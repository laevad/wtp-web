<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Tracking;
use App\Models\ApiKey;


class AdminTracking extends Tracking
{
    public function render()
    {
        $apiKey = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();
        return view('livewire.admin.admin-tracking',
            [
                'apiKey' => $apiKey,
            ]);
    }
}
