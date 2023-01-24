<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\bookings\UpdateBooking;
use App\Models\ApiKey;
use App\Models\GenMerch;
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
    public function updateBooking()
    {
        $this->validateUpdateBooking();

        $this->booking->update($this->state);
        $this->state = [];
        $this->disable = false;
        return redirect()->route('admin.booking-list')->with('success', 'Booking updated successfully!');
    }
    public function render(): Factory|View|Application
    {
        $trip_status = TripStatus::all();
        $clients =User::where('role_id', '=', User::ROLE_CLIENT)->get();
        $drivers =User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $vehicles = Vehicle::all();
        /*gen merch*/
        $gen_merch = GenMerch::all();
        $apiKey = $this->getApiKey();
        $role ='admin';
        return view('livewire.admin.admin-update-booking',[
            'clients' =>$clients,
            'vehicles'=>$vehicles,
            'drivers'=>$drivers,
            'apiKey'=> $apiKey,
            'trip_status'=>$trip_status,
            'role'=>$role,
            'gen_merch'=>$gen_merch
        ]);
    }
}
