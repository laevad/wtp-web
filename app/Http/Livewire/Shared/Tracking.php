<?php
namespace App\Http\Livewire\Shared;


use App\Models\Booking;
use Livewire\Component;

class Tracking extends Component{

    public $bookingId;
    public $fromLatitude;
    public $fromLongitude;
    public $toLatitude;
    public $toLongitude;

    public function mount(Booking $booking){
        $this->bookingId = $booking->id;
        $this->fromLatitude = $booking->from_latitude;
        $this->fromLongitude = $booking->from_longitude;
        $this->toLatitude = $booking->to_latitude;
        $this->toLongitude = $booking->to_longitude;
    }
}
