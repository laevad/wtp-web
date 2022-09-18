<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\bookings\AddBooking;
use App\Models\ApiKey;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;

class AdminAddBooking extends AddBooking
{

    public function render()
    {
        $role ='admin';
        $trip_status = TripStatus::all();
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        $apiKey = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();
        return view('livewire.admin.admin-add-booking',[
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
            'apiKey'=> $apiKey,
            'trip_status'=>$trip_status,
            'role'=>$role
        ]);
    }
}
