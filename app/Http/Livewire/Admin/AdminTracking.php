<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Tracking;


class AdminTracking extends Tracking
{

    public function render()
    {
        return view('livewire.admin.admin-tracking');
    }
}
