<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\reports\BookingReports;
use App\Models\Vehicle;

class AdminBookingReport extends BookingReports
{
    public function render()
    {
        $vehicles = Vehicle::all();
        return view('livewire.admin.admin-booking-report',[
            'vehicles'=>$vehicles,
        ]);
    }
}
