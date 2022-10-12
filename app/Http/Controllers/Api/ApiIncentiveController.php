<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiIncentiveController extends Controller
{
    public string $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function incentive(Request $request): JsonResponse
    {
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
        $incentives = Cash::join('bookings', 'cashes.booking_id', '=' ,'bookings.id')
            ->join('users', 'bookings.driver_id', '=', 'users.id')
            ->select('cashes.created_at', 'cashes.amount', 'cashes.note', 'cashes.date')
            ->where('cash_type_id', '=', Cash::CASH_INCENTIVE)
            ->where('users.id',$request->input('user_id'))
            ->orderBy('cashes.created_at', 'DESC')->paginate(12);
        return response()->json($incentives);
    }
}
