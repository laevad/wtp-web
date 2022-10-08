<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\UpdateBooking;


class ClientUpdateBooking extends UpdateBooking
{
    public function render()
    {
        return view('livewire.client.client-update-booking');
    }
}
