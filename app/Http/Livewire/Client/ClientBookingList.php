<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\BookingList;
use App\Models\ApiKey;
use App\Models\Booking;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;


class ClientBookingList extends BookingList
{
    public function getBookingQuery(){
        return  Booking::join('users','users.id','=', 'bookings.user_id')
//            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
//            ->join('users as driver','driver.id','=', 'bookings.driver_id')
            ->select('bookings.id', 'bookings.user_id','bookings.vehicle_id', 'bookings.t_trip_start',
                'bookings.t_trip_end','bookings.driver_id', 'bookings.trip_start_date','bookings.trip_end_date',
                'bookings.trip_status_id','bookings.t_total_distance','bookings.created_at')

            ->where('bookings.user_id', '=', auth()->user()->id)
            ->orderBy('bookings.created_at', 'DESC')->paginate(5);
    }



    public function render()
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
        $role ='client';
        return view('livewire.client.client-booking-list',[
            'bookings'=> $bookings,
            'trip_status' => $trip_status,
            'apiKey'=>$apiKey,
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
            'role'=>$role,
        ]);
    }
}
