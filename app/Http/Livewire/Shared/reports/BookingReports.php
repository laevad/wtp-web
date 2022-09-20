<?php
namespace App\Http\Livewire\Shared\reports;

use App\Models\Booking;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class BookingReports extends  Component{
    use WithPagination;
    public $viewMode = false;
    public $state=[];
    protected $listeners = ['dateSelected'=>'dateSelectedRange'];
    private $bookingReport ;
    protected $queryString = [];

    protected $paginationTheme ='bootstrap';




    public function rBooking(Request $request){
        if ($request->ajax()) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $vehicle_id = $request->input('vehicle_id');

            if ($request->input('start_date') && $request->input('end_date')) {


                if ($vehicle_id=='all'){
                    $bookings = Booking::join('users','users.id','=', 'bookings.user_id')
                        ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
                        ->join('users as driver','driver.id','=', 'bookings.driver_id')
                        ->join('trip_statuses as statuses','statuses.id','=', 'bookings.trip_status_id')
                        ->select( 'users.name as client','vehicles.name as vehicle',
                            'driver.name as driver','bookings.t_trip_end','bookings.driver_id', 'bookings.t_trip_start',
                            'bookings.t_trip_end','bookings.trip_start_date','bookings.trip_end_date','statuses.name as status',
                            'bookings.t_total_distance','bookings.created_at')
                        ->orderBy('bookings.created_at','DESC')
                        ->whereBetween('bookings.created_at', [$start_date, $end_date])
                        ->get();
                }else{
                    $bookings = Booking::join('users','users.id','=', 'bookings.user_id')
                        ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
                        ->join('users as driver','driver.id','=', 'bookings.driver_id')
                        ->join('trip_statuses as statuses','statuses.id','=', 'bookings.trip_status_id')
                        ->select( 'users.name as client','vehicles.name as vehicle',
                            'driver.name as driver','bookings.t_trip_end','bookings.driver_id', 'bookings.t_trip_start',
                            'bookings.t_trip_end','bookings.trip_start_date','bookings.trip_end_date','statuses.name as status',
                            'bookings.t_total_distance','bookings.created_at')
                        ->orderBy('bookings.created_at','DESC')
                        ->where('bookings.vehicle_id', '=', $vehicle_id)
                        ->whereBetween('bookings.created_at', [$start_date, $end_date])
                        ->get();
                }
            } else {
//                $date = Carbon::now()->subDays(7);

                $bookings = Booking::join('users','users.id','=', 'bookings.user_id')
                    ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
                    ->join('users as driver','driver.id','=', 'bookings.driver_id')
                    ->join('trip_statuses as statuses','statuses.id','=', 'bookings.trip_status_id')
                    ->select( 'users.name as client','vehicles.name as vehicle',
                        'driver.name as driver','bookings.t_trip_end','bookings.driver_id', 'bookings.t_trip_start',
                        'bookings.t_trip_end','bookings.trip_start_date','bookings.trip_end_date','statuses.name as status',
                        'bookings.t_total_distance','bookings.created_at')
                    ->orderBy('bookings.created_at','DESC')
//                        ->whereRaw("bookings.created_at between '$start_date' and '$end_date'")
                    ->whereBetween('bookings.created_at', [$start_date, $end_date])
                    ->get();

            }

            return response()->json([
                'bookings' => $bookings
            ]);
        } else {
            abort(403);
        }


    }
}
