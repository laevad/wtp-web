<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\reports\EIReport;
use App\Models\Cash;
use App\Models\CashType;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCashReport extends EIReport
{
    public function report(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $driver_id = $request->input('driver_id');
        $cash_type_id = $request->input('cash_type_id');
        if ($request->ajax()) {
            if ($request->input('start_date') && $request->input('end_date') ) {


                if ($driver_id =='all' && $cash_type_id == 'all'){
                    $ei = $this->getAllDataCustom($start_date, $end_date);
                }
                if ($driver_id !='all' && $cash_type_id == 'all'){
                    $ei = Cash::join('bookings','bookings.id','=', 'cashes.booking_id')
                        ->join('cash_types','cash_types.id','=', 'cashes.cash_type_id')
                        ->join('users as drivers','drivers.id', '=', 'bookings.driver_id')
                        ->join('cash_types as types','types.id', '=', 'cashes.cash_type_id')
                        ->select('drivers.name','cashes.date', 'cashes.note', 'cashes.amount', 'types.name as type','cashes.created_at')
                        ->where('drivers.id' , '=', $driver_id)
                        ->whereBetween('bookings.created_at', [$start_date, $end_date])
                        ->orderBy('cashes.created_at','DESC')
                        ->get();
                }

                else{
                    if ($driver_id != 'all'){
                        $ei = Cash::join('bookings','bookings.id','=', 'cashes.booking_id')
                            ->join('cash_types','cash_types.id','=', 'cashes.cash_type_id')
                            ->join('users as drivers','drivers.id', '=', 'bookings.driver_id')
                            ->join('cash_types as types','types.id', '=', 'cashes.cash_type_id')
                            ->select('drivers.name','cashes.date', 'cashes.note', 'cashes.amount', 'types.name as type','cashes.created_at')
                            ->where('cashes.cash_type_id' , '=', $cash_type_id)
                            ->where('drivers.id' , '=', $driver_id)
                            ->whereBetween('bookings.created_at', [$start_date, $end_date])
                            ->orderBy('cashes.created_at','DESC')
                            ->get();
                    }
                    if ($cash_type_id != 'all'){
                        $ei = Cash::join('bookings','bookings.id','=', 'cashes.booking_id')
                            ->join('cash_types','cash_types.id','=', 'cashes.cash_type_id')
                            ->join('users as drivers','drivers.id', '=', 'bookings.driver_id')
                            ->join('cash_types as types','types.id', '=', 'cashes.cash_type_id')
                            ->select('drivers.name','cashes.date', 'cashes.note', 'cashes.amount', 'types.name as type','cashes.created_at')
                            ->where('cashes.cash_type_id' , '=', $cash_type_id)
                            ->whereBetween('bookings.created_at', [$start_date, $end_date])
                            ->orderBy('cashes.created_at','DESC')
                            ->get();
                    }
                }
            }else{
                $ei = $this->getAllDataCustom($start_date, $end_date);
            }
            return response()->json([
                'ie' => $ei
            ]);
        }else {
            abort(403);
        }
    }

    public function render()
    {


        $drivers = User::where('role_id', '=', User::ROLE_DRIVER)->get();
        $cashType=CashType::all();
        return view('livewire.admin.admin-cash-report',[
            'drivers'=>$drivers,
            'cashType'=>$cashType
        ]);
    }
}
