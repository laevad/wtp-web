<?php
namespace App\Http\Livewire\Shared;


use App\Models\Booking;
use App\Models\Location;
use App\Models\Marker;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Tracking extends Component{

    public $bookingId;
    public $fromLatitude;
    public $fromLongitude;
    public $toLatitude;
    public $toLongitude;

    public $booking;
    public $markers ;
    public $currentLocation;
    public $bookingStatus;
    public $userId;

    protected $listeners = ['refreshComponent' => 'reload'];

    public function mount(Booking $booking){
        $this->bookingId = $booking->id;
        $this->bookingStatus = $booking->trip_status_id;
        $this->userId = $booking->driver_id;
        $this->booking = $booking;
        $this->fromLatitude = $booking->from_latitude;
        $this->fromLongitude = $booking->from_longitude;
        $this->toLatitude = $booking->to_latitude;
        $this->toLongitude = $booking->to_longitude;

        $this->markers = Marker::where('booking_id' , '=', $this->bookingId)->get();
        $this->currentLocation = Location::where('user_id', '=', $this->userId)->get();


    }

    public function reload(){
        return Redirect::route('admin.tracking', $this->bookingId);
    }

}
