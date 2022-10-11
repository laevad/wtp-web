<?php
namespace App\Http\Livewire\Shared;

use App\Models\Booking;
use App\Models\Cash;
use Illuminate\Support\Facades\Validator;

class CashController extends GlobalVar{
    public $listeners= ['addExpense'=>'addedExpense', 'addIncentive'=>'addedIncentive'];
    public $expenseGonnaAdd;
    public $incentiveGonnaAdd;
    public $expense;
    public $incentive;
    public $isExpense = false;

    public function addNew(){
        $this->showEditModal= false;
        $this->state = [];
        $this->viewMode = false;
        $this->isExpense = true;
        $this->dispatchBrowserEvent('show-form');
    }


    public function addIncentive(){
        $this->isExpense = false;
        $this->showEditModal= false;
        $this->state = [];
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form-incentive');
    }



    /*EDIT*/
    public function editExpense(Cash $cash){
        $b =Booking::where('id', '=', $cash->booking_id)->first();
//        dd($b->vehicle->name);
        $this->isExpense = true;
        $this->state = [];
        $this->viewMode=false;
        $this->showEditModal = true;
        $this->state = $cash->toArray();
        $this->state['vehicle'] = $b->vehicle->name;
        $this->expense = $cash;
        $this->dispatchBrowserEvent('show-form');
    }
    public function editIncentive(Cash $cash){
        $b =Booking::where('id', '=', $cash->booking_id)->first();

        $this->isExpense = false;
        $this->state = [];
        $this->viewMode=false;
        $this->showEditModal = true;
        $this->state = $cash->toArray();
        $this->state['driver'] = $b->driver->name;
        $this->incentive = $cash;
        $this->dispatchBrowserEvent('show-form-incentive');
    }

    public function updateExpense(){
        $validateData = Validator::make($this->state,[
            'date'=>'required',
            'amount'=>'required|numeric',
            'note'=>'nullable',
            'expense_type_id' => 'required'
        ],[
            'vehicle_id.required'=>'The vehicle field is required.',
            'expense_type_id.required'=>'The expense type field is required.',
        ])->validate();

        $this->expense->update($validateData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Expense updated successfully']);
        return redirect()->back();
    }

    public function updateIncentives(){
        $validateData = Validator::make($this->state,[
            'date'=>'required',
            'amount'=>'required|numeric',
            'note'=>'nullable',
        ],[
            'vehicle_id.required'=>'The vehicle field is required.'
        ])->validate();

        $this->incentive->update($validateData);
        $this->dispatchBrowserEvent('hide-form-incentive', ['message'=>'Expense updated successfully']);
        return redirect()->back();
    }


    public function createExpense(){
        $validateData = Validator::make($this->state,[
            'vehicle_id'=>'required',
            'date'=>'required',
            'amount'=>'required|numeric',
            'note'=>'required'
        ],[
            'vehicle_id.required'=>'The vehicle field is required.'
        ])->validate();
        $validateData['cash_type_id']= Cash::CASH_EXPENSE;
        if ($validateData != null){
            $this->dispatchBrowserEvent('show-warn-add');
            $this->expenseGonnaAdd = $validateData;
        }
    }

    public function createIncentive(){
        $validateData = Validator::make($this->state,[
            'vehicle_id'=>'required',
            'date'=>'required',
            'amount'=>'required|numeric',
            'note'=>'required',
        ],[
            'vehicle_id.required'=>'The vehicle field is required.'
        ])->validate();
        $validateData['cash_type_id']= Cash::CASH_INCENTIVE;
        if ($validateData != null){
            $this->dispatchBrowserEvent('show-warn-add-incentive');
            $this->incentiveGonnaAdd = $validateData;
        }
    }


    public function addedExpense(){
        Cash::create($this->expenseGonnaAdd);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Expense added successfully']);
        return redirect()->back();
    }

    public function addedIncentive(){
        Cash::create($this->incentiveGonnaAdd);
        $this->dispatchBrowserEvent('hide-form-incentive', ['message'=>'Incentive added successfully']);
        return redirect()->back();
    }
}
