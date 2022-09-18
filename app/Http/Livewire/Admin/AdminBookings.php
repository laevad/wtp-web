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
        return view('livewire.admin.admin-bookings',[
            'bookings'=> $bookings,
            'trip_status' => $trip_status,
            'apiKey'=>$apiKey,
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
        ]);
    }
    private function getBookingQuery(){
        return  Booking::join('users','users.id','=', 'bookings.user_id')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('users as driver','driver.id','=', 'bookings.driver_id')
            ->select('bookings.id', 'bookings.user_id','bookings.vehicle_id', 'bookings.t_trip_start','bookings.t_trip_end','bookings.driver_id', 'bookings.trip_start_date','bookings.trip_end_date','bookings.trip_status_id','bookings.t_total_distance')
            ->where('users.name', 'LIKE', '%'. $this->searchTerm."%")
            ->orWhere('bookings.t_trip_start', 'LIKE', '%'. $this->searchTerm."%")
            ->orWhere('bookings.t_trip_end', 'LIKE', '%'. $this->searchTerm."%")
            ->orWhere('driver.name', 'LIKE', '%'. $this->searchTerm."%")
            ->orWhere('vehicles.name', 'LIKE', '%'. $this->searchTerm."%")
            ->orderBy('bookings.id', 'DESC')->paginate(5);
    }
}
