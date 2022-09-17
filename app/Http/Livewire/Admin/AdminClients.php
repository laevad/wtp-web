<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\Clients;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminClients extends Clients
{
//    custom get user
    private function getUserQuery(): LengthAwarePaginator
    {
        return  User::query()->where('role_id', '=',User::ROLE_CLIENT)
            ->where('name', 'like',"%".$this->searchTerm."%")
            ->orWhere('email', 'like',"%".$this->searchTerm."%")
            ->where('role_id', 'like',"%".User::ROLE_CLIENT."%")

            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->latest()->paginate(5);
    }
    public function render()
    {
        $users = $this->getUserQuery();

        if (count($users) == 0){
            $this->resetPage();
            $this->getUserQuery();
        }
        return view('livewire.admin.admin-clients', [
            'users' =>$users
        ]);
    }
}
