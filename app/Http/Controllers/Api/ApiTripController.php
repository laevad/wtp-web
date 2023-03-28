<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cash;
use App\Models\Incentise;
use App\Models\Location;
use App\Models\TripStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiTripController extends Controller
{
    public string $guard = 'api';

    public $status = null;

    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function trip(Request $request): JsonResponse
    {

        $validators = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id',
            'trip_status_id' => ['nullable', Rule::in(TripStatus::YET_TO_START, TripStatus::COMPLETE, TripStatus::ON_GOING, TripStatus::CANCELLED)],

        ]);
        $this->status = $request->input('trip_status_id');
        $errors = $validators->errors();
        $err = [
            'driver_id' => $errors->first('driver_id'),
            'trip_status_id' => $errors->first('trip_status_id'),
        ];

        $check_id = Booking::where('driver_id', '=', $request->input('driver_id'))->first();
        if ($validators->fails()) {
            return response()->json([
                'errors' => $err
            ], 422);
        }
        if ($this->status == null) {
            $booking = $this->getBookingApiQuery($request);
        } else {
            $booking = $this->getBookingApiQueryComplete($request);
        }


        return response()->json($booking);
    }

    public function tripComplete(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',

        ]);
        $errors = $validators->errors();
        $err = [
            'driver_id' => $errors->first('driver_id'),
            'booking_id' => $errors->first('booking_id'),
        ];


        /*UPDATE the location status to 2*/
        Location::where('user_id', '=', $request->input('driver_id'))->update(['status_id' => 2]);

        /*check booking*/
        $check_id = Booking::where('id', '=', $request->input('booking_id'))->first();
        $trip_end = strtolower($check_id['t_trip_end']);

        /*list of incentise only name and id to array*/
        $incentise = Incentise::select('amount', 'name')->get()->toArray();

        $amount = null;
        $name = null;
        foreach ($incentise as $value) {
            if (str_contains($trip_end, strtolower($value['name']))) {
                /*get the data id*/
                $amount = $value['amount'];
                $name = $value['name'];
                break;
            }
        }



        if ($validators->fails() || $amount == null || $name == null) {
            return response()->json([
                'errors' => $err
            ], 422);
        }
        /*add Cashes  with cash_type_id = 2*/
        Cash::create([
            'amount' => $amount,
            'cash_type_id' => 2,
            'booking_id' => $request->input('booking_id'),
            'note' => $name,
        ]);
      /*response added*/
        return response()->json([
            'message' => 'Cash added',
            'cash' => $amount,
            'note' => $name,
        ]);
    }

    public function updateTripStatus(Request $request): JsonResponse
    {
        /*set default time zone manila*/
        date_default_timezone_set('Asia/Manila');
        $validators = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'status_id' => 'required|exists:trip_statuses,id',
        ]);
        $errors = $validators->errors();
        $err = [
            'booking_id' => $errors->first('booking_id'),
            'status_id' => $errors->first('status_id'),
        ];
        if ($validators->fails()) {
            return response()->json([
                'errors' => $err
            ], 422);
        }
        $book = Booking::where('id', '=', $request->input('booking_id'));
        $book->update([
            'trip_status_id' => $request->input('status_id'),
            /*date completed now*/
            'date_completed' => now(),
        ]);

        /*get the book user_id only*/
        $user_id = $book->first()->driver_id;
        /*get user location in location*/
        $location = Location::where('user_id', '=', $user_id)->first();
        /*set the status_id = 3 if the request status_id input = 3 */
        if ($request->input('status_id') == 3) {
            $location->update(['status_id' => 1]);
        }
        return response()->json(['message' => 'success update!', 'errors' => $err], 201);
    }

    public function getBookingApiQuery(Request $request)
    {

        return Booking::join('users', 'users.id', '=', 'bookings.user_id')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('users as driver', 'driver.id', '=', 'bookings.driver_id')
            ->join('users as client', 'client.id', '=', 'bookings.user_id')
            ->join('trip_statuses', 'trip_statuses.id', '=', 'bookings.trip_status_id')
            ->select('bookings.id', 'driver.id as driver_id', 'client.id as client_id', 'users.name as client', 'vehicles.name as vehicle',
                'bookings.t_trip_start', 'bookings.t_trip_end', 'driver.name as driver',
                'bookings.trip_start_date', 'bookings.trip_end_date',
                'trip_statuses.name as trip_status', 'bookings.t_total_distance', 'bookings.created_at', 'bookings.trip_status_id as status_id',
                'bookings.from_latitude', 'bookings.from_longitude', 'bookings.to_latitude', 'bookings.to_longitude')
            ->where('bookings.driver_id', '=', $request->input('driver_id'))
            ->where('driver.role_id', '=', User::ROLE_DRIVER)
            ->where('bookings.trip_status_id', '!=', TripStatus::COMPLETE)
            ->orderBy('bookings.created_at', 'DESC')->paginate(12);
    }

    public function getBookingApiQueryComplete($request)
    {
        return Booking::join('users', 'users.id', '=', 'bookings.user_id')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('users as driver', 'driver.id', '=', 'bookings.driver_id')
            ->join('users as client', 'client.id', '=', 'bookings.user_id')
            ->join('trip_statuses', 'trip_statuses.id', '=', 'bookings.trip_status_id')
            ->select('bookings.id', 'driver.id as driver_id', 'client.id as client_id', 'users.name as client', 'vehicles.name as vehicle',
                'bookings.t_trip_start', 'bookings.t_trip_end', 'driver.name as driver',
                'bookings.trip_start_date', 'bookings.trip_end_date',
                'trip_statuses.name as trip_status', 'bookings.t_total_distance', 'bookings.created_at', 'bookings.trip_status_id as status_id',
                'bookings.from_latitude', 'bookings.from_longitude', 'bookings.to_latitude', 'bookings.to_longitude', 'bookings.date_completed')
            ->where('bookings.driver_id', '=', $request->input('driver_id'))
            ->where('driver.role_id', '=', User::ROLE_DRIVER)
            ->where('bookings.trip_status_id', '=', $this->status)
            ->orderBy('bookings.created_at', 'DESC')->paginate(12);
    }
}
