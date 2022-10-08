<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\AddBooking;


class ClientAddBooking extends AddBooking
{
    public function render()
    {
        return view('livewire.client.client-add-booking');
    }
}
