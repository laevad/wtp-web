<?php
namespace  App\Http\Livewire\Shared;

use App\Models\Status;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Vehicles extends GlobalVar{

    public $listeners = ['deleteConfirmed'=> 'deleteVehicle',  'deleteSelected'=>'deletedSelectedVehicleRows' ];
    public function addNew(){
        $this->showEditModal= false;
        $this->photo = null;
        $this->state = ['status_id'=>VehicleStatus::ACTIVE];
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createVehicle(){
        $validatedData = $this->validateVehicle();
        Vehicle::create($validatedData);
        $this->disable = false;
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Vehicle added successfully']);
        $this->resetPage();
        return redirect()->back();
    }


    /*View*/
    public function view(Vehicle $vehicle){
        //        $this->reset();
        $this->state = [];
        $this->showEditModal = false;
        $this->viewMode = true;
        $this->state = $vehicle->toArray();
        $this->vehicle = $vehicle;
        $this->dispatchBrowserEvent('show-form');
    }


    /*EDIT*/
    public function editVehicle(Vehicle $vehicle){
        //        $this->reset();
        $this->state = [];
        $this->viewMode=false;
        $this->showEditModal = true;
        $this->state = $vehicle->toArray();
        $this->vehicle = $vehicle;
        $this->dispatchBrowserEvent('show-form');
    }


    /*update*/
    public function updateVehicle(): RedirectResponse
    {

        $validatedData = $this->validateVehicle();
        $this->disable = false;
        $this->vehicle->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver updated successfully']);
        return redirect()->back();
    }

    public function confirmVehicleRemoval($vehicleId){
        $this->vehicleBeingRemoved = $vehicleId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }


    public function deleteVehicle(){
        try {
            $vehicle = Vehicle::findOrFail($this->vehicleBeingRemoved);
            $vehicle->delete();
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->dispatchBrowserEvent('deleted', ['message'=>'Vehicle deleted successfully']);
        }catch (\Exception){
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
            $this->dispatchBrowserEvent('error-booking', ['message'=>'Vehicle deleted unsuccessfully']);

        }
    }

    /*SELECTED*/
    public function updatedSelectedPageRows($value){
        if ($value){
            $this->selectedRows = $this->vehicles->pluck('id')->map(function ($id){
                return (string) $id;
            });
        }else{
            $this->reset(['selectedRows', 'selectedPageRows']);
        }
    }

    public function deletedSelectedVehicleRows(){
        try {
            Vehicle::whereIn('id',$this->selectedRows)->delete();
            $this->dispatchBrowserEvent('deleted',['message'=>'All selected vehicles got deleted.']);
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
        }catch(\Exception){
            $this->dispatchBrowserEvent('error-booking', ['message'=>'Vehicle deleted unsuccessfully']);
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
        }
    }


    public function getVehiclesProperty(): LengthAwarePaginator
    {
        return Vehicle::query()
            ->latest()->paginate(5);
    }


    /*inactive and active*/
    public function markAsActive(){
        Vehicle::whereIn('id', $this->selectedRows)->update(['status'=>'ACTIVE']);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as active']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }
    public function markAsInactive(){
        Vehicle::whereIn('id', $this->selectedRows)->update(['status'=>'INACTIVE']);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as inactive']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }


    public function getVehicleStatus(): Collection
    {
        return VehicleStatus::all();
    }

    public function validateVehicle(){

        if ($this->showEditModal){
            return  Validator::make($this->state,[
                'registration_number'=>'required|min:3|max:120',
                'name'=>'required|min:2|max:120',
                'model'=>'required|min:3|max:120',
                'chassis_no'=>'required|min:3|max:120',
                'engine_no'=>'required|min:3|max:120',
                'manufactured_by'=>'required|min:3|max:120',
                'registration_expiry_date'=>'required|date',
                'status_id'=> ['required', Rule::in([VehicleStatus::ACTIVE, VehicleStatus::MAINTENANCE, VehicleStatus::INACTIVE])]
            ])->validate();
        }

        return Validator::make($this->state,[
            'registration_number'=>'required|min:3|max:120',
            'name'=>'required|min:2|max:120',
            'model'=>'required|min:3|max:120',
            'chassis_no'=>'required|min:3|max:120',
            'engine_no'=>'required|min:3|max:120',
            'manufactured_by'=>'required|min:3|max:120',
            'registration_expiry_date'=>'required|date',
            'status_id'=> ['required', Rule::in([VehicleStatus::ACTIVE, VehicleStatus::MAINTENANCE, VehicleStatus::INACTIVE])]
        ])->validate();
    }

    public function updated(){
        $validatedData = $this->validateVehicle();
        if(isset($validatedData)){
            $this->disable = true;
        }
    }

}
