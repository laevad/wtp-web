<?php
namespace  App\Http\Livewire\Shared;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class Vehicles extends GlobalVar{
    public $listeners = ['deleteConfirmed'=> 'deleteVehicle',  'deleteSelected'=>'deletedSelectedVehicleRows' ];
    public function addNew(){
        $this->showEditModal= false;
        $this->photo = null;
        $this->state = ['status'=>'ACTIVE'];
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createVehicle(){
        $validatedData = Validator::make($this->state,[
            'registration_number'=>'required',
            'name'=>'required',
            'model'=>'required',
            'chassis_no'=>'required',
            'engine_no'=>'required',
            'manufactured_by'=>'required',
            'registration_expiry_date'=>'required',
            'status'=> 'required'
        ])->validate();
        Vehicle::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Vehicle added successfully']);
        $this->resetPage();
        return redirect()->back();
    }


    /*View*/
    public function view(Vehicle $vehicle){
        //        $this->reset();
        $this->state = [];
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
    public function updateVehicle()
    {

        $validatedData = Validator::make($this->state,[
            'registration_number'=>'required',
            'name'=>'required',
            'model'=>'required',
            'chassis_no'=>'required',
            'engine_no'=>'required',
            'manufactured_by'=>'required',
            'registration_expiry_date'=>'required',
            'status'=> 'required'
        ])->validate();

        $this->vehicle->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver updated successfully']);
        return redirect()->back();
    }

    public function confirmVehicleRemoval($vehicleId){
        $this->vehicleBeingRemoved = $vehicleId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }


    public function deleteVehicle(){
        $vehicle = Vehicle::findOrFail($this->vehicleBeingRemoved);
        $vehicle->delete();
        $this->reset(['selectedRows', 'selectedPageRows']);
        $this->dispatchBrowserEvent('deleted', ['message'=>'Vehicle deleted successfully']);
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
        Vehicle::whereIn('id',$this->selectedRows)->delete();
        $this->dispatchBrowserEvent('deleted',['message'=>'All selected vehicles got deleted.']);
        $this->reset(['selectedRows', 'selectedPageRows']);
        $this->resetPage();
    }


    public function getVehiclesProperty(){
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

}
