<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cash;
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
            ->select('cashes.created_at', 'cashes.amount', 'expense_types.name as expense_type')
            ->where('cash_type_id', '=', Cash::CASH_EXPENSE)
            ->where('users.id',$request->input('user_id'))
            ->get();
        return response()->json(['data'=>$expenses]);
    }
}
