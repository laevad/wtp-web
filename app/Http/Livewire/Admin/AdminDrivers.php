<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Drivers;
use App\Models\Status;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AdminDrivers extends Drivers
{
    public function render(): Factory|View|Application
    {
        $users = $this->getDriverQuery();
        if (count($users) == 0){
            $this->resetPage();
            $this->getDriverQuery();
        }
        $this->cPageChanges($users->currentPage());
        $status = $this->getUserStatus();
        return view('livewire.admin.admin-drivers',[
            'users'=>$users,
            'status'=>$status
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
