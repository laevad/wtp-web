<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Vehicles;
use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class AdminVehicles extends Vehicles
{
    public function render()
    {
        $vehicles = $this->getVehicleQuery();
        if (count($vehicles) == 0){
            $this->resetPage();
            $vehicles = $this->getVehicleQuery();

        }
        $this->cPageChanges($vehicles->currentPage());
        return view('livewire.admin.admin-vehicles', [
            'vehicles'=> $vehicles
        ]);
    }

    private function getVehicleQuery(): LengthAwarePaginator
    {
        return Vehicle::query()
            ->where('name', 'like', "%" . $this->searchTerm . "%")
            ->orWhere('model', 'like', "%" . $this->searchTerm . "%")
            ->orWhere('manufactured_by', 'like', "%" . $this->searchTerm . "%")
            ->orWhere('chassis_no', 'like', "%" . $this->searchTerm . "%")
            ->orWhere('engine_no', 'like', "%" . $this->searchTerm . "%")
            ->latest()->paginate(5);
    }
}
