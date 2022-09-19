<?php
namespace App\Http\Livewire\Shared\bookings;

use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateBooking extends Component{
    public $isUpdate = false;
    public $viewMode = false;
    public $state= [];
    public $booking;
    protected $listeners =['total_distance' => 'totalDistance'];


    public function totalDistance($t_distance){
        $this->state['t_total_distance'] = $t_distance;
    }


    public function mount(Booking $booking){
        $this->state = $booking->toArray();
        $this->booking = $booking;
    }


}
