<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\ViewBooking;


class ClientViewBooking extends ViewBooking
{
    public function render()
    {
        return view('livewire.client.client-view-booking');
    }
}
