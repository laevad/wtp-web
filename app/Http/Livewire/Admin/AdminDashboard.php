<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Dashboard;
use App\Models\Location;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class AdminDashboard extends Dashboard
{
    public int $totalVehicle;
    public int $totalDriver;
    public int $totalClient;

    public function render(): Factory|View|Application
    {
        $location = Location::all();
        /*count status = 2 in location*/
        $offStatus= $location->where('status_id', '=', 1)->count();


        return view('livewire.admin.admin-dashboard',[
            'location'=>$location,
            'offStatus'=>$offStatus,
        ]);
    }

    function countTotal($name): int
    {
        if ($name =='vehicle')
            return Vehicle::all()->count();
        if ($name =='driver')
            return User::where('role_id', '=', User::ROLE_DRIVER)->get()->count();
        if ($name =='client')
            return User::where('role_id', '=', User::ROLE_CLIENT)->get()->count();
    }

    public function mount(){
       $this->totalVehicle = $this->countTotal('vehicle');
       $this->totalDriver = $this->countTotal('driver');
       $this->totalClient = $this->countTotal('client');
    }


}
