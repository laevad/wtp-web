<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiTripController extends Controller
{
    public string $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function trip(): JsonResponse
    {
        $booking = Booking::join('users','users.id','=', 'bookings.user_id')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('users as driver','driver.id','=', 'bookings.driver_id')
            ->join('trip_statuses','trip_statuses.id','=', 'bookings.trip_status_id')
            ->select('bookings.id', 'users.name as client','vehicles.name as vehicle',
                'bookings.t_trip_start','bookings.t_trip_end','driver.name as driver',
                'bookings.trip_start_date','bookings.trip_end_date',
                'trip_statuses.name as trip_status','bookings.t_total_distance','bookings.created_at',
                'bookings.from_latitude', 'bookings.from_longitude','bookings.to_latitude', 'bookings.to_longitude')
            ->orderBy('bookings.created_at', 'DESC')->paginate(12);
        return response()->json($booking);
    }
    public function updateTripStatus(Request $request): JsonResponse
    {
        return response()->json(['msg'=>'ok']);
    }
}
