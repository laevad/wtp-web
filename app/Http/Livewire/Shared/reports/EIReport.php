<?php
namespace App\Http\Livewire\Shared\reports;

use App\Models\Cash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class EIReport extends Component{

    public function getAllData(){
        $date = Carbon::today();
        return Cash::join('bookings','bookings.id','=', 'cashes.booking_id')
            ->join('cash_types','cash_types.id','=', 'cashes.cash_type_id')
            ->join('users as drivers','drivers.id', '=', 'bookings.driver_id')
            ->join('cash_types as types','types.id', '=', 'cashes.cash_type_id')
            ->select('drivers.name','cashes.date', 'cashes.note', 'cashes.amount', 'types.name as type','cashes.created_at')
            ->orderBy('cashes.created_at','DESC')
            ->where('cashes.created_at' , '>=', $date)
            ->get();
    }
    public function getAllDataCustom($start_date, $end_date){
        return Cash::join('bookings','bookings.id','=', 'cashes.booking_id')
            ->join('cash_types','cash_types.id','=', 'cashes.cash_type_id')
            ->join('users as drivers','drivers.id', '=', 'bookings.driver_id')
            ->join('cash_types as types','types.id', '=', 'cashes.cash_type_id')
            ->select('drivers.name','cashes.date', 'cashes.note', 'cashes.amount', 'types.name as type','cashes.created_at')
            ->orderBy('cashes.created_at','DESC')
            ->whereBetween('bookings.created_at', [$start_date, $end_date])
            ->get();
    }
}
