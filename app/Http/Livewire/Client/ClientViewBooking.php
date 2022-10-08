<?php

namespace App\Http\Livewire\Client;

use App\Http\Livewire\Shared\bookings\ViewBooking;
use App\Models\Cash;


class ClientViewBooking extends ViewBooking
{
    public function render()
    {
        $expenses = Cash::where('cash_type_id', '=', Cash::CASH_EXPENSE)
            ->where('booking_id', '=', $this->bookingId)
            ->latest()
            ->paginate(5);
        $incentives = Cash::where('cash_type_id', '=', Cash::CASH_INCENTIVE)
            ->where('booking_id', '=', $this->bookingId)
            ->latest()
            ->paginate(5);
        if (count($expenses)==0){
            $this->resetPage();
            $expenses = Cash::where('cash_type_id', '=', Cash::CASH_EXPENSE)
                ->where('booking_id', '=', $this->bookingId)
                ->latest()
                ->paginate(5);
            $incentives = Cash::where('cash_type_id', '=', Cash::CASH_INCENTIVE)
                ->where('booking_id', '=', $this->bookingId)
                ->latest()
                ->paginate(5);
        }
        $role ='client';
        return view('livewire.client.client-view-booking', [
            'expenses' => $expenses,'incentives'=>$incentives, 'role'=>$role
        ]);
    }
}
