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
    protected $listeners = [
        'deleteSelectedExpense'=>'deleteExpense',
        'deleteSelectedIncentive'=> 'deleteIncentive',
        'acceptIncentive' => 'acceptIncentive',
        'acceptExpense' => 'acceptExpense',
        /*decline*/
        'declineIncentive' => 'declineIncentive',
        'declineExpense' => 'declineExpense',
    ];
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
            'note' =>'nullable',
            'expense_type_id' => 'required'
        ],[
            'expense_type_id.required' =>'The expense type field is required.'
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


    /*show accept incentive*/
    public function showAcceptIncentive($id){
        $this->dispatchBrowserEvent('show-accept-incentive-modal', ['id'=>$id]);
    }

    /*show accept expense*/
    public function showAcceptExpense($id){
        $this->dispatchBrowserEvent('show-accept-expense-modal', ['id'=>$id]);
    }

    /*show decline incentive*/
    public function showDeclineIncentive($id){
        $this->dispatchBrowserEvent('show-decline-incentive-modal', ['id'=>$id]);
    }

    /*show decline expense*/
    public function showDeclineExpense($id){
        $this->dispatchBrowserEvent('show-decline-expense-modal', ['id'=>$id]);
    }

    public function acceptIncentive($id){
        /*check if date_completed is not null*/
        $incentive = Cash::findOrFail($id);
        /*get booking in incentive*/
        $booking = $incentive->booking;
        if($booking->date_completed != null) {
            if ($booking->date_completed <=$booking->trip_end_date ) {
                $incentive->update(['is_accept' => Cash::STATUS_ACCEPTED]);
                $this->dispatchBrowserEvent('acceptedIncentive',
                    ['message' => 'Incentive accepted successfully']);
            }
            else {
                $incentive->update(['is_accept' => Cash::STATUS_DECLINED]);
                $this->dispatchBrowserEvent('show-error', ['message' => 'Incentive cannot be accepted because the date completed is greater than the trip end date']);
            }

        }
        /*else trip is not complete yet*/
        else{
            $this->dispatchBrowserEvent('show-error', ['message' => 'Incentive cannot be accepted because the trip is not yet completed']);
        }
    }

    public function acceptExpense($id){
        /*check if date_completed is not null*/
        $expense = Cash::findOrFail($id);
        /*get booking in incentive*/
        $booking = $expense->booking;
        if($booking->date_completed != null) {
            if ($booking->date_completed <=$booking->trip_end_date ) {
                $expense->update(['is_accept' => Cash::STATUS_ACCEPTED]);
                $this->dispatchBrowserEvent(
                    'acceptedExpense'
                    , ['message' => 'Expense accepted successfully']);
            }
            else {
                $expense->update(['is_accept' => Cash::STATUS_DECLINED]);
                $this->dispatchBrowserEvent('show-error', ['message' => 'Expense cannot be accepted because the date completed is greater than the trip end date']);
            }

        }
        /*else trip is not complete yet*/
        else{
            $this->dispatchBrowserEvent('show-error', ['message' => 'Expense cannot be accepted because the trip is not yet completed']);
        }
    }

    public function declineIncentive($id){
        $incentive = Cash::findOrFail($id);
        $incentive->update(['is_accept' => Cash::STATUS_DECLINED]);
        $this->dispatchBrowserEvent('declineIncentive', ['message' => 'Incentive declined successfully']);
    }

    public function declineExpense($id)
    {
        $expense = Cash::findOrFail($id);
        $expense->update(['is_accept' => Cash::STATUS_DECLINED]);
        $this->dispatchBrowserEvent('declineExpense', ['message' => 'Expense declined successfully']);
    }
}
