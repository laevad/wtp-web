<?php
namespace App\Http\Livewire\Shared\bookings;

use App\Http\Livewire\Shared\GlobalVar;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookingList extends  GlobalVar{

    public $bookingBeingRemoved;

    public $listeners = ['deleteConfirmedBooking'=>'deleteBooking', 'deleteSelectedBooking'=>'deletedSelectedRowsBooking'];

    public $state= ['trip_status_id'=>1];

    public $status  ;

    protected $queryString = ['status'];


    public function getBookingQuery(){
        return  Booking::when($this->status, function ($query , $status){
            return $query->where('trip_status_id', $status);
        })
        ->latest()->paginate(5);
    }


    public function  filterBookingByStatus($status = null){
        $this->reset(['selectedRows', 'selectedPageRows']);
        $this->reset();
        $this->status = $status;
    }


    /*add modal */
    public function addNew(){
        $this->showEditModal= false;
        $this->photo = null;
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form');
    }


    /*create booking*/
    public function createBooking(): RedirectResponse
    {
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

        ],[
            'user_id.required'=>'The client field is required.',
            'vehicle_id.required'=>'The vehicle field is required.',
            'driver_id.required'=>'The driver field is required.',
            't_trip_start.required'=>'The trip start location field is required.',
            't_trip_end.required'=>'The trip end location field is required.',
            'trip_status_id.required'=>'The trip status field is required.',
        ])->validate();
//        dd($validatedData);
        Booking::create($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['message'=>'Booking added successfully']);
        $this->resetPage();
        return redirect()->back();


    }



    public function changeStatus(Booking $booking, $status){
        Validator::make(['trip_status_id'=>$status],[
                'trip_status_id'=>[
                    'required',
                    Rule::in(Booking::YET_TO_START, Booking::COMPLETE, Booking::ON_GOING, Booking::CANCELLED, Booking::PENDING),
                ],
            ]
        )->validate();
        if ( $status == 1){
            $trip_stats = 'yet to start';
        }elseif ($status == 2) {
            $trip_stats = 'complete';
        }elseif ($status == 3) {
            $trip_stats = 'on going';
        }else{
            $trip_stats = 'cancelled';
        }
        /*if status is complete update also the date_completed*/
        if ($status == 2){
            $booking->update(['trip_status_id'=>$status, 'date_completed'=>now()]);
        }else{
            /*update the status then clear*/
            $booking->update(['trip_status_id'=>$status, 'date_completed'=>null]);
        }
        $this->dispatchBrowserEvent('updated', ['message'=>"Role changed to {$trip_stats} successfully!"]);
    }

    public function confirmUserRemoval($bookingId){
        $this->bookingBeingRemoved = $bookingId;
        $this->dispatchBrowserEvent('show-delete-confirmation-booking');
    }

    public function deleteBooking(){
        try {
            $booking = Booking::findOrFail($this->bookingBeingRemoved);
            $booking->delete();
            $this->dispatchBrowserEvent('deleted', ['message'=>'Booking deleted successfully']);
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
        }catch (\Exception ){
            $this->dispatchBrowserEvent('error-booking', ['message'=>'Booking deleted unsuccessfully']);
        }

    }
    public function confirmSelectedBookingRemoval(){
        $this->dispatchBrowserEvent('show-select-delete-confirmation-booking');
    }

    public function deletedSelectedRowsBooking(){
        try {
            Booking::whereIn('id',$this->selectedRows)->delete();
            $this->dispatchBrowserEvent('deleted',['message'=>'All selected booking/s got deleted.']);
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
        }catch(\Exception){
            $this->dispatchBrowserEvent('error-booking', ['message'=>'Booking deleted unsuccessfully']);
        }
    }

    /*SELECTED*/
    public function updatedSelectedPageRows($value){
        if ($value){
            $this->selectedRows = $this->bookings->pluck('id')->map(function ($id){
                return (string) $id;
            });
        }else{
            $this->reset(['selectedRows', 'selectedPageRows']);
        }
    }

    public function getBookingsProperty(){
        return $this->getBookingQuery();
    }

    public function deletedSelectedRows(){
        Booking::whereIn('id',$this->selectedRows)->delete();
        $this->dispatchBrowserEvent('deleted',['message'=>'All selected booking/s got deleted.']);
        $this->reset(['selectedRows', 'selectedPageRows']);
        $this->resetPage();
    }
}
