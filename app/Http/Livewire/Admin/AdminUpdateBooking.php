<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\bookings\UpdateBooking;
use App\Models\ApiKey;
use App\Models\TripStatus;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminUpdateBooking extends UpdateBooking
{
    /**
     * @throws ValidationException
     */
    public function updateBooking(): RedirectResponse
    {
        Validator::make($this->state,[
            'user_id'=>'required',
            'vehicle_id'=>'required',
            'driver_id'=>'required',
            't_trip_start'=>'required',
            't_trip_end'=>'required',
            'trip_status_id'=>'required|in:1,2,3,4',
            'trip_start_date'=>'required|date',
            'trip_end_date'=>'required|date',
            't_total_distance'=>'required|numeric',

        ],[
            'user_id.required'=>'The client field is required.',
            'vehicle_id.required'=>'The vehicle field is required.',
            'driver_id.required'=>'The driver field is required.',
            't_trip_start.required'=>'The trip start location field is required.',
            't_trip_end.required'=>'The trip end location field is required.',
            'trip_status_id.required'=>'The trip status field is required.',
            't_total_distance.numeric'=>'The total distance must be a number.',
            't_total_distance.required'=>'The total distance field is required.',
        ])->validate();

        $this->booking->update($this->state);
        $this->state = [];
        return redirect()->route('admin.booking-list')->with('success', 'Booking updated successfully!');
    }
    public function render(): Factory|View|Application
    {
        $trip_status = TripStatus::all();
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        $apiKey = ApiKey::where('id', 1)->pluck('name')->first();
        $role ='admin';
        return view('livewire.admin.admin-update-booking',[
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
            'apiKey'=> $apiKey,
            'trip_status'=>$trip_status,
            'role'=>$role
        ]);
    }
}
