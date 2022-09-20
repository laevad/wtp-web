
<div class="modal fade " id="form-incentive" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Incentives</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off"  wire:submit.prevent="updateIncentives"  >
                <div class="modal-body">
                    <div class="row">
                        <x-custom.input model="driver" :isView="true" isAddBooking="true"></x-custom.input>
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

