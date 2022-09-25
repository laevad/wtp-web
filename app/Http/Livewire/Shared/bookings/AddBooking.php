<?php
namespace App\Http\Livewire\Shared\bookings;

use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddBooking extends  Component{

    public $isUpdate = false;
    public $viewMode = false;
    public $state= ['trip_status_id'=>1];
    public $total_distance;
    protected $listeners =[
        'total_distance' => 'totalDistance'
    ];


    public function totalDistance($t_distance,$lat,$lon,$lat1,$lon1){
        $this->state['t_total_distance'] = $t_distance;
        $this->state['from_latitude'] = $lat;
        $this->state['from_longitude'] = $lon;
        $this->state['to_latitude'] = $lat1;
        $this->state['to_longitude'] = $lon1;
    }



    public function createBooking(){
//        dd($this->state);
        $validatedData = Validator::make($this->state,[
            'user_id'=>'required',
            'vehicle_id'=>'required',
            'driver_id'=>'required',
            't_trip_start'=>'required',
            't_trip_end'=>'required',
            'trip_status_id'=>'required|in:1,2,3,4',
            'trip_start_date'=>'required|date',
            'trip_end_date'=>'required|date',
            't_total_distance'=>'required|numeric',
            'from_latitude'=>'',
            'from_longitude'=>'',
            'to_latitude'=>'',
            'to_longitude'=>'',

        ],[
            'user_id.required'=>'The client field is required.',
            'vehicle_id.required'=>'The vehicle field is required.',
            'driver_id.required'=>'The driver field is required.',
            't_trip_start.required'=>'The trip start location field is required.',
            't_trip_end.required'=>'The trip end location field is required.',
            'trip_status_id.required'=>'The trip status field is required.',
            't_total_distance.numeric'=>'The total distance must be a number.',
            't_total_distance.required'=>'The total distance field is required.',
        ])->validate();
        $validatedData['t_total_distance'] = $this->state['t_total_distance'];
//        dd($validatedData);
        Booking::create($validatedData);
        $this->state=[];
        return redirect()->route('admin.booking-list')->with('success', 'Booking added successfully!');
    }
    /*unselect selected row if click next / previous*/
    public  int $cPage =0 ;


}
