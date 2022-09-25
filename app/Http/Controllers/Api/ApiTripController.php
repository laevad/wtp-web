<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ApiTripController extends Controller
{
    public  $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function trip(){
        $booking = Booking::join('users','users.id','=', 'bookings.user_id')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('users as driver','driver.id','=', 'bookings.driver_id')
            ->join('trip_statuses','trip_statuses.id','=', 'bookings.trip_status_id')
            ->select('bookings.id', 'users.name as client','vehicles.name as vehicle',
                'bookings.t_trip_start','bookings.t_trip_end','driver.name as driver',
                'bookings.trip_start_date','bookings.trip_end_date',
                'trip_statuses.name as trip_status','bookings.t_total_distance','bookings.created_at')
            ->where('trip_statuses.id', '!=', '2')
                ->orderBy('bookings.id', 'DESC')->paginate(12);
        return response()->json($booking);
    }
}
