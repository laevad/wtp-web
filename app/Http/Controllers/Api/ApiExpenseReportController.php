<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cash;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiExpenseReportController extends Controller
{
    public string $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }
    public function getExpense(Request $request){
        $validators = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        $errors = $validators->errors();
        $err = [
            'user_id' => $errors->first('user_id'),
        ];
        if ($validators->fails()){
            return response()->json(['errors' => $err], 422);
        }
        $expenses = Cash::join('bookings', 'cashes.booking_id', '=' ,'bookings.id')
            ->join('users', 'bookings.driver_id', '=', 'users.id')
            ->join('expense_types', 'cashes.expense_type_id', '=', 'expense_types.id')
            ->select(
                'cashes.created_at', 'cashes.amount',
                'expense_types.name as expense_type', 'cashes.note', 'cashes.date')
            ->where('cash_type_id', '=', Cash::CASH_EXPENSE)
            ->where('users.id',$request->input('user_id'))
            ->orderBy('cashes.created_at', 'DESC')->paginate(12);
        return response()->json($expenses);
    }

    public function getExpenseType(){
        $expType = ExpenseType::all();
        return response()->json(['data'=>$expType]);
    }
    public function getBookingStartEnd(Request $request){
        $validators = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        $errors = $validators->errors();
        $err = [
            'user_id' => $errors->first('user_id'),
        ];
        if ($validators->fails()){
            return response()->json(['errors' => $err], 422);
        }
        $bookingSE = Booking::select('id','t_trip_start as trip_start', 't_trip_end as trip_end')
            ->where('driver_id', '=',$request->input('user_id'))
            ->get();
        if ($bookingSE->isEmpty()){
            return response()->json(
                ['data'=>[
                    [
                        'id'=>'',
                        'trip_start'=>'',
                        'trip_end'=>'',
                    ]
                ]
            ]);
        }
        return response()->json(['data'=>$bookingSE]);
    }

    public function addExpense(Request $request){
        $validators = Validator::make($request->all(), [
            'expense_type_id' => 'required|exists:expense_types,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'description'=>'nullable'
        ]);
        $errors = $validators->errors();
        $err = [
            'expense_type_id' => $errors->first('expense_type_id'),
            'amount' => $errors->first('amount'),
            'description' => $errors->first('description'),
            'booking_id' => $errors->first('booking_id'),
        ];
        if ($validators->fails()){
            return response()->json(['errors' => $err], 422);
        }
        $expense = new Cash;
        $expense->date = now()->toFormattedDate();
        $expense->cash_type_id = 1;
        $expense->expense_type_id = $request->input('expense_type_id');
        $expense->amount = $request->input('amount');
        $expense->note = $request->input('description');
        $expense->booking_id = $request->input('booking_id');
        $expense->save();
        return response()->json(['errors' => $err, 'data'=> $expense]);
    }
}
