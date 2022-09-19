<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\CashController;

class AdminCash extends CashController
{
    public function render()
    {
        return view('livewire.admin.admin-cash');
    }
}
