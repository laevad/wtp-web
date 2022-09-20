<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\CashController;
use App\Models\Cash;

class AdminCash extends CashController
{
    public function render()
    {
        $expenses = Cash::query()->where('cash_type_id', '=', Cash::CASH_EXPENSE)->latest()->paginate(5);
        $incentives = Cash::query()->where('cash_type_id', '=', Cash::CASH_INCENTIVE)->latest()->paginate(5);
        $role ='admin';
        return view('livewire.admin.admin-cash',[
            'expenses'=>$expenses,
            'incentives'=>$incentives,
            'role'=>$role
        ]);
    }
}
