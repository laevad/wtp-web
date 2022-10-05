<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Dashboard;
use App\Models\Location;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class AdminDashboard extends Dashboard
{
    public function render(): Factory|View|Application
    {
        $location = Location::all()->toArray();
        return view('livewire.admin.admin-dashboard',[
            'location'=>$location
        ]);
    }


}
