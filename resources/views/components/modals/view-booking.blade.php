@props(['booking' =>[], 'isIncentive'=>false])
<div class="modal fade " id="form" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $isIncentive ? 'Add Incentive' : 'Add Trip Expense' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $isIncentive? 'addIncentives' :'addExpense' }}('{{ $booking->trip_start_date }}')" >
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                        <div class="col-sm-8">
                            <input  type="text" class="form-control @error('amount') is-invalid @enderror"  name="amount" id="amount" placeholder="Enter amount" autocomplete="off" wire:model.defer="state.amount">
                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="note" class="col-sm-4 col-form-label">Notes/Description</label>
                        <div class="form-group col-sm-8">
                            <textarea class="form-control "  wire:model.defer="state.note" placeholder="Enter Notes"></textarea>
                            @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times mr-2"></i>Close</button>
                    <button type="submit" class="btn customBg text-white"><i class="fa fa-save mr-2"></i>Save {{ $isIncentive? 'Incentive' : 'Expense' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

