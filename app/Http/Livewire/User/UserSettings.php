<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\Shared\Settings;


class UserSettings extends Settings
{
    public function render()
    {
        return view('livewire.user.user-settings');
    }
}
