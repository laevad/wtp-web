@props(['expenseType'])
<div class="modal fade " id="form" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expenses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off"  wire:submit.prevent="updateExpense"  >
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="expense_type_id" class=" form-label">Type</label>
                            <div class=" @error('expense_type_id') is-invalid border  border-danger round  @enderror">
                                <x-custom.select id="expense_type_id" :view="false">
                                    <option value="">Select Expense Status</option>
                                    @foreach($expenseType as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </x-custom.select>
                            </div>
                            @error('expense_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <x-custom.input model="vehicle" :isView="true" isAddBooking="true"></x-custom.input>
                        <x-custom.input model="date" isAddBooking="true" isDate="true"></x-custom.input>
                        <x-custom.input model="amount" isAddBooking="true" ></x-custom.input>
                    </div>
                    <div class="col-sm-12 ">
                        <label for="note" class="">Notes</label>
                        <textarea class="form-control"  wire:model.defer="state.note" placeholder="Enter Notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times mr-2"></i>Cancel</button>
                    <button type="submit" class="btn customBg text-white"><i class="fa fa-save mr-2"></i>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

