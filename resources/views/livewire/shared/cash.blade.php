<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                {{--                            <button wire:click.prevent="addNew" class="btn customBg text-white"><i class="fa fa-plus-circle mr-1"></i>Add new expense</button>--}}
                {{--                            <button wire:click.prevent="addIncentive" class="btn btn-secondary text-white"><i class="fa fa-plus-circle mr-1"></i>Add new incentive</button>--}}
            </div>
            {{--                        <div class="">--}}
            {{--                            <input type="text" class="form-control border-0" placeholder="Search" wire:model="searchTerm">--}}
            {{--                            <div class="" wire:loading.delay wire:target="searchTerm">--}}
            {{--                                <div class="la-ball-clip-rotate la-dark la-sm" >--}}
            {{--                                    <div></div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Expenses</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-responsive-sm table-responsive-md table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Vehicle</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Amount</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>

                    <tbody wire:loading.class="text-muted">
                    @forelse($expenses as $index=>$data)
                        <tr class="">
                            <th scope="row">{{ $expenses->firstItem() + $index }}</th>
                            <td>{{ $data->booking->vehicle->name }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->note==null? 'N/A' : $data->note }}</td>
                            <td>{{ $data->amount }}</td>

                            <td>
                                <a href="" wire:click.prevent="editExpense({{ $data }})">
                                    <i class="fa fa-edit mr-2"></i>
                                </a> <a target="_new" href="{{ route("$role.booking-details", $data->booking_id ) }}">
                                    <i class="fa fa-eye text-success"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="6"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end" style="">
                {{ $expenses->onEachSide(0)->links() }}
            </div>
        </div>

    </div>
    <div class="col-md-6 col-sm-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                {{--                            <button wire:click.prevent="addNew" class="btn customBg text-white"><i class="fa fa-plus-circle mr-1"></i>Add new expense</button>--}}
                {{--                            <button wire:click.prevent="addIncentive" class="btn btn-secondary text-white"><i class="fa fa-plus-circle mr-1"></i>Add new incentive</button>--}}
            </div>
            {{--                        <div class="">--}}
            {{--                            <input type="text" class="form-control border-0" placeholder="Search" wire:model="searchTerm">--}}
            {{--                            <div class="" wire:loading.delay wire:target="searchTerm">--}}
            {{--                                <div class="la-ball-clip-rotate la-dark la-sm" >--}}
            {{--                                    <div></div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Incentive</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-responsive-sm table-responsive-md table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Driver</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Amount</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>

                    <tbody wire:loading.class="text-muted">
                    @forelse($incentives as $index=>$data)
                        <tr class="">
                            <th scope="row">{{ $incentives->firstItem() + $index }}</th>
                            <td>{{ $data->booking->driver->name }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->note==null? 'N/A' : $data->note }}</td>
                            <td>{{ $data->amount }}</td>


                            <td>
                                <a href="" wire:click.prevent="editIncentive({{ $data }})">
                                    <i class="fa fa-edit mr-2"></i>
                                </a> <a target="_new" href="{{ route("$role.booking-details", $data->booking_id ) }}">
                                    <i class="fa fa-eye text-success"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="6"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end" style="">
                {{ $expenses->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
</div>
@if($isExpense)
    <x-modals.expenses></x-modals.expenses>
@else
    <x-modals.incentives></x-modals.incentives>
@endif


