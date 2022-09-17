<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Drivers;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminDrivers extends Drivers
{
    public function render()
    {
        $users = $this->getDriverQuery();
        if (count($users) == 0){
            $this->resetPage();
            $this->getDriverQuery();
        }
        return view('livewire.admin.admin-drivers',[
            'users'=>$users
        ]);
    }

    private function getDriverQuery(): LengthAwarePaginator
    {
        return User::query()->where('role_id', '=',User::ROLE_DRIVER)
            ->where('name', 'like',"%".$this->searchTerm."%")
            ->orWhere('email', 'like',"%".$this->searchTerm."%")
            ->where('role_id', 'like',"%".User::ROLE_DRIVER."%")
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->latest()->paginate(5);
    }
}
