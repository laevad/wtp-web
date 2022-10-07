<?php
namespace App\Http\Livewire\Shared;


use App\Models\Booking;
use Livewire\Component;

class Tracking extends Component{

    public $bookingId;

    public function mount(Booking $booking){
        $this->bookingId = $booking->id;
    }
}
