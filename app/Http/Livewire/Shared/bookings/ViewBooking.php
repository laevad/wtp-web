<?php
namespace App\Http\Livewire\Shared\bookings;

use App\Models\Booking;
use App\Models\Cash;
use App\Models\ExpenseType;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ViewBooking extends Component{
    use WithPagination;
    public $state = [];
    public $booking;
    public $expenseBeingRemoved;
    public $incentiveBeingRemoved;
    public $isIncentive;
    protected $listeners = ['deleteSelectedExpense'=>'deleteExpense', 'deleteSelectedIncentive'=> 'deleteIncentive'];
    protected $paginationTheme ='bootstrap';

    public $bookingId ;

    public function addExpenses(){
        $this->state = [];
        $this->isIncentive = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function addIncentive(){
        $this->state = [];
        $this->isIncentive = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function addExpense($date){
        $validateData = Validator::make($this->state,[
            'amount' =>'required|numeric',
            'note' =>'nullable'
        ])->validate();
        $validateData['date'] = $date;
        $validateData['booking_id'] = $this->bookingId;
        $validateData['cash_type_id'] = Cash::CASH_EXPENSE;

        Cash::create($validateData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Expense added successfully']);
        return redirect()->back();
    }
    public function addIncentives( $date){
        $validateData = Validator::make($this->state,[
            'amount' =>'required|numeric',
            'note' =>'nullable'
        ])->validate();
        $validateData['date'] = $date;
        $validateData['booking_id'] = $this->bookingId;
        $validateData['cash_type_id'] = Cash::CASH_INCENTIVE;

        Cash::create($validateData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Incentive added successfully']);
        return redirect()->back();
    }

    public function mount(Booking $booking){

        $this->booking = $booking;
        $this->bookingId = $booking->id;
    }

    public function confirmExpenseRemoval($expenseId){
        $this->expenseBeingRemoved = $expenseId;
        $this->dispatchBrowserEvent('show-select-delete-confirmation-expense');
    }

    public function confirmIncentiveRemoval($incentiveId){
        $this->incentiveBeingRemoved = $incentiveId;
        $this->dispatchBrowserEvent('show-select-delete-confirmation-incentive');
    }

    public function deleteExpense(){
        $expense = Cash::findOrFail($this->expenseBeingRemoved);
        $expense->delete();
        $this->dispatchBrowserEvent('deleted', ['message'=>'Expense deleted successfully']);
    }

    public function deleteIncentive(){
        $incentive =  Cash::findOrFail($this->incentiveBeingRemoved);
        $incentive->delete();
        $this->dispatchBrowserEvent('deleted', ['message'=>'Incentive deleted successfully']);
    }

    public function getExpensesType(){
        return ExpenseType::all();
    }
}
