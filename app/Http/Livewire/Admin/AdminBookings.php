<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\bookings\BookingList;
use App\Models\ApiKey;
use App\Models\Booking;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AdminBookings extends BookingList
{
    public function render(): Factory|View|Application
    {
        $bookings = $this->getBookingQuery();
        $b = $bookings;

            $apiKey = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();

        $trip_status = TripStatus::all();
        if (count($b) == 0){
            $this->resetPage();
            $bookings = $this->getBookingQuery();

        }
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        $this->cPageChanges($bookings->currentPage());
        return view('livewire.admin.admin-bookings',[
            'bookings'=> $bookings,
            'trip_status' => $trip_status,
            'apiKey'=>$apiKey,
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
        ]);
    }

}
