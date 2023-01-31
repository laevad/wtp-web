<?php

namespace App\Http\Livewire\Shared\bookings;

use App\Models\Booking;
use App\Models\TripStatus;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddBooking extends Component
{

    public $isUpdate = false;
    public $viewMode = false;
    public $state = ['trip_status_id' => TripStatus::YET_TO_START, 't_total_distance' => 0];
    public $total_distance;
    public bool $disable = false;
    /*unselect selected row if click next / previous*/
    public int $cPage = 0;

    protected $listeners = [
        'total_distance' => 'totalDistance'
    ];


    public function totalDistance($t_distance, $lat, $lon, $lat1, $lon1)
    {
        $this->state['t_total_distance'] = $t_distance;
        $this->state['from_latitude'] = $lat;
        $this->state['from_longitude'] = $lon;
        $this->state['to_latitude'] = $lat1;
        $this->state['to_longitude'] = $lon1;
    }


    public function createBooking()
    {
        if (auth()->user()->role_id == User::ROLE_ADMIN) {
            $validatedData = $this->validateAddBooking();
            /*change date_completed format to 2023-01-31*/

        }
        if (auth()->user()->role_id == User::ROLE_CLIENT) {
            $validatedData = $this->validateAddBookingClient();
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['trip_status_id'] = Booking::PENDING;
        }

        $validatedData['t_total_distance'] = $this->state['t_total_distance'];
        /*gen merches*/
        Booking::create($validatedData);
        $this->state = [];
        if (auth()->user()->role_id == User::ROLE_ADMIN) {
            return redirect()->route('admin.booking-list')->with('success', 'Booking added successfully!');
        }
        return redirect()->route('client.booking-list')->with('success', 'Booking added successfully!');
    }

    public function validateAddBooking()
    {
        return Validator::make($this->state, [
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => ['required', Rule::exists('users', 'id')],
            't_trip_start' => 'min:2|max:200|required_with:t_trip_end',
            't_trip_end' => 'required|max:200',
            'trip_status_id' => ['required', Rule::in(TripStatus::YET_TO_START, TripStatus::COMPLETE, TripStatus::ON_GOING, TripStatus::CANCELLED, TripStatus::PENDING)],
            'trip_start_date' => ['required', 'date', 'after_or_equal:today', 'required_with:driver_id,vehicle_id',
                /*custom function query trip_start_date with no conflict driver_id*/
                function ($attribute, $value, $fail) {
                    /*check driver*/
                    try {
                        $driver_id = $this->state['driver_id'];
                        /*catch end date*/
                        try {
                            /*check state isset*/
                            $trip_start_date = date('Y-m-d', strtotime($value));
                            $trip_end_date = date('Y-m-d', strtotime($this->state['trip_end_date']));
                            $trip = Booking::where('trip_start_date', '<=', $trip_end_date)
                                ->where('trip_end_date', '>=', $trip_start_date)
                                ->where('driver_id', $driver_id)
                                /*ongoing or yet to start*/
                                ->whereIn('trip_status_id', [TripStatus::YET_TO_START, TripStatus::ON_GOING])
                                ->first();
                            if ($trip) {
                                $fail('The driver is already booked on this date.');
                            }
                        }catch (\Exception $e){
                            /*end date*/
                            $fail('End date field id required .');
                        }
                    } catch (\Exception $e) {
                        $fail('Please select driver and vehicle.');
                    }
                },
                /*check vehicle*/
                function ($attribute, $value, $fail) {
                   /*try catch*/
                    try {
                        $vehicle_id = $this->state['vehicle_id'];
                        try {
                            $trip_start_date = date('Y-m-d', strtotime($value));
                            /*end date*/
                            $trip_end_date = date('Y-m-d', strtotime($this->state['trip_end_date']));

                            $trip = Booking::where('trip_start_date', '<=', $trip_end_date)
                                ->where('trip_end_date', '>=', $trip_start_date)
                                ->where('vehicle_id', $vehicle_id)
                                /*ongoing or yet to start*/
                                ->whereIn('trip_status_id', [TripStatus::YET_TO_START, TripStatus::ON_GOING])
                                ->first();
                            if ($trip) {
                                $fail('The vehicle is already booked on this date.');
                            }
                        }catch (\Exception $e){
                            /*start date*/
                            $fail('Start date field id required .');
                        }
                    } catch (\Exception $e) {
                        $fail('Please select driver and vehicle.');
                    }
                }
            ],
            'trip_end_date' => ['required', 'date', 'after_or_equal:today',
                /*custom function query trip_start_date with no conflict driver_id*/
                function ($attribute, $value, $fail) {
                    /*check driver*/
                    try {
                        $driver_id = $this->state['driver_id'];
                        /*catch end date*/
                        try {
                            /*check state isset*/
                            $trip_start_date = date('Y-m-d', strtotime($this->state['trip_start_date']));
                            $trip_end_date = date('Y-m-d', strtotime($value));
                            $trip = Booking::where('trip_start_date', '<=', $trip_end_date)
                                ->where('trip_end_date', '>=', $trip_start_date)
                                ->where('driver_id', $driver_id)
                                /*ongoing or yet to start*/
                                ->whereIn('trip_status_id', [TripStatus::YET_TO_START, TripStatus::ON_GOING])
                                ->first();
                            if ($trip) {
                                $fail('The driver is already booked on this date.');
                            }
                        }catch (\Exception $e){
                            /*end date*/
                            $fail('End date field id required .');
                        }
                    } catch (\Exception $e) {
                        $fail('Please select driver and vehicle.');
                    }
                },
                /*check vehicle*/
                function ($attribute, $value, $fail) {
                    /*try catch*/
                    try {
                        $vehicle_id = $this->state['vehicle_id'];
                        try {
                            $trip_start_date = date('Y-m-d', strtotime($this->state['trip_start_date']));
                            /*end date*/
                            $trip_end_date = date('Y-m-d', strtotime($value));
                            $trip = Booking::where('trip_start_date', '<=', $trip_end_date)
                                ->where('trip_end_date', '>=', $trip_start_date)
                                ->where('vehicle_id', $vehicle_id)
                                /*ongoing or yet to start*/
                                ->whereIn('trip_status_id', [TripStatus::YET_TO_START, TripStatus::ON_GOING])
                                ->first();
                            if ($trip) {
                                $fail('The vehicle is already booked on this date.');
                            }
                        }catch (\Exception $e){
                            /*start date*/
                            $fail('Start date field id required .');
                        }
                    } catch (\Exception $e) {
                        $fail('Please select driver and vehicle.');
                    }
                },
                'after_or_equal:trip_start_date',
                ],
            't_total_distance' => 'numeric',
            /*from latitude required t_trip_start*/
            'from_latitude' => '',
            'from_longitude' => '',
            'to_latitude' => '',
            'to_longitude' => '',
            'gen_merch_id' => 'required|exists:gen_merches,id'
        ], [
            'user_id.required' => 'The client field is required.',
            'vehicle_id.required' => 'The vehicle field is required.',
            'driver_id.required' => 'The driver field is required.',
            't_trip_start.required' => 'The origin location field is required.',
            't_trip_end.required' => 'The destination location field is required.',
            'trip_status_id.required' => 'The trip status field is required.',
            't_total_distance.numeric' => 'The total distance must be a number.',
            't_total_distance.required' => 'The total distance field is required.',
            'gen_merch_id.required' => 'The general merchandise field is required.',
            /*t_trip_end required_with:t_trip_start*/
            't_trip_end.required_with' => 'The destination location field is required when origin location is present.',


        ])->validate();
    }

    public function validateAddBookingClient()
    {
        return Validator::make($this->state, [
            't_trip_start' => 'required|max:200',
            't_trip_end' => 'required|max:200',
            'trip_start_date' => 'required|date',
            'trip_end_date' => 'required|date',
            't_total_distance' => 'numeric',
            'from_latitude' => '',
            'from_longitude' => '',
            'to_latitude' => '',
            'to_longitude' => '',
            'gen_merch_id' => 'required|exists:gen_merches,id'

        ], [
            't_trip_start.required' => 'The trip start location field is required.',
            't_trip_end.required' => 'The trip end location field is required.',
            't_total_distance.numeric' => 'The total distance must be a number.',
            't_total_distance.required' => 'The total distance field is required.',
            'gen_merch_id.required' => 'The general merchandise field is required.',
        ])->validate();
    }

}
