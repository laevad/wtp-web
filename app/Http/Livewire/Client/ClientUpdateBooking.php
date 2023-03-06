<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\UpdateBooking;
use App\Models\GenMerch;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;


class ClientUpdateBooking extends UpdateBooking
{


    public function updateBooking()
    {
        $this->validateUpdateBookingClient();
        $this->booking->update($this->state);
        $this->state = [];
        $this->disable = false;
        return redirect()->route('client.booking-list')->with('success', 'Booking updated successfully!');
    }
    public function render()
    {
        $trip_status = TripStatus::all();
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        $apiKey = $this->getApiKey();
        $gen_merch = GenMerch::all();
        $role ='client';
        return view('livewire.client.client-update-booking', [
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
            'apiKey'=> $apiKey,
            'trip_status'=>$trip_status,
            'role'=>$role,
            'gen_merch'=>$gen_merch,
        ]);
    }
}
