<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\BookingList;

class AdminBookings extends BookingList
{
    public function render()
    {
        return view('livewire.admin.admin-bookings');
    }
}
