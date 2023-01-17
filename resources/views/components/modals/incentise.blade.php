<div class="modal fade" id="incentiseAdd" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalLabel"
     aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="" wire:ignore.self>
                <form autocomplete="off" wire:submit.prevent="updateIncentise">
                    <div class="modal-body">
                        {{--custom input--}}
                        <div class="row">
                            {{--name--}}
                            <div class="col form-group">
                                <label for="name">Name</label>
                                <input type="text" placeholder="name"
                                       class="form-control @error('name_up') is-invalid @enderror"
                                       wire:model.defer="incentiveData.name_up">
                                @error('name_up')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{--amount--}}
                            <div class="col form-group">
                                <label for="amount">Amount</label>
                                <input type="number" placeholder="₱"
                                       class="form-control @error('amount_up') is-invalid @enderror"
                                       wire:model.defer="incentiveData.amount_up">
                                @error('amount_up')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="" wire:loading.delay>
                            <x-animation.ball-clip></x-animation.ball-clip>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times mr-2"></i>Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" class="btn customBg text-white"><i class="fa fa-save mr-2" ></i>Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
