<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\AddBooking;
use App\Models\ApiKey;
use App\Models\GenMerch;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;


class ClientAddBooking extends AddBooking
{
    public function render()
    {
        $role ='client';
        $trip_status = TripStatus::all();
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        $apiKey = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();
        /*gen merch*/
        $gen_merch = GenMerch::all();
        return view('livewire.client.client-add-booking', [
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
