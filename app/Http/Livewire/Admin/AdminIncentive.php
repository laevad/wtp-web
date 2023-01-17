<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Shared\CashController;
use App\Http\Livewire\Shared\GlobalVar;
use App\Models\Incentise;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AdminIncentive extends GlobalVar
{
    public $role = 'admin';

    public $incentiveRemove;

    public $listeners = ['deleteConfirmed' => 'deleteIncentive'];

    public $incentive = [];
    public $incentiveData;


    public function render()
    {
        $incentises = Incentise::
        where('name', 'like', "%" . $this->searchTerm . "%")
            ->latest()->paginate(5);
        return view('livewire.admin.admin-incentive', [
            'incentises' => $incentises
        ]);
    }

    /*deleteIncentise*/
    public function deleteIncentise($id)
    {
        $incentise = Incentise::find($id);
        $incentise->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => 'Incentive Deleted Successfully!']);
    }

    public function confirmIncentiseRemoval($incenId)
    {
        $this->incentiveRemove = $incenId;
        $this->dispatchBrowserEvent('show-delete-confirmation-incentive');
    }

    /*edit*/
    public function editIncentise(Incentise $incentise)
    {
        $tmp_arr =$incentise->toArray();
        /*name_up*/
        $tmp_arr['name_up'] = $tmp_arr['name'];
        /*amount_up*/
        $tmp_arr['amount_up'] = $tmp_arr['amount'];
        $this->incentiveData = $tmp_arr;
        $this->dispatchBrowserEvent('show-form-incentise-add');
    }

    /*update*/
    public function updateIncentise()
    {
        $validatedData = $this->validatedIncentiveData();
        /*name*/
        $validatedData['name'] = $validatedData['name_up'];
        /*amount*/
        $validatedData['amount'] = $validatedData['amount_up'];
        /*unset amount_up*/
        unset($validatedData['amount_up']);
        /*unset name_up*/
        unset($validatedData['name_up']);
        $incentise = Incentise::find($this->incentiveData['id']);
        $incentise->update($validatedData);
        /*reset*/
        $this->reset();
        $this->dispatchBrowserEvent('hide-form-incentise-add', ['message' => 'Incentive Updated Successfully!']);
        /*redirect*/
        return redirect()->back();
    }

    public function deleteIncentive()
    {
        $this->deleteIncentise($this->incentiveRemove);
    }

    /*validate Incentive using Validator::make in $incentive array*/
    public function validateIncentive()
    {
        return Validator::make($this->incentive, [
            'name' => 'required|max:255',
            'amount' => 'required|digits_between:2,6',
        ])->validate();
    }

    public function validatedIncentiveData(){;
        return Validator::make($this->incentiveData, [
            'name_up' => 'required|max:255',
            'amount_up' => 'required|digits_between:2,6',
        ],[
            'name_up.required' => 'Name is required',
            'amount_up.required' => 'Amount is required',
        ])->validate();
    }

    /*add incentive*/
    public function addIncentive()
    {
        $validatedData = $this->validateIncentive();
        $this->validateIncentive();
        Incentise::create($validatedData);
        $this->dispatchBrowserEvent('added', ['message' => 'Incentive Added Successfully!']);
        $this->incentive = [];
        $this->reset();
    }


}
