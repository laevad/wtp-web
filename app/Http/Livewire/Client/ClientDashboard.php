<?php

namespace App\Http\Livewire\Client;

use App\Models\Location;
use Livewire\Component;

class ClientDashboard extends Component
{
    public function render()
    {
        $location = Location::join('bookings', 'bookings.driver_id', '=', 'locations.user_id')
            ->where('bookings.user_id', '=', auth()->user()->id)->get();
        $offStatus = $location->where('status_id', '=', 1)->count();
        return view('livewire.client.client-dashboard', [
                'location' => $location,
                'offStatus' => $offStatus,
            ]
        );
    }
}
