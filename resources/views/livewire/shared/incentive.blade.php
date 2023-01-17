<x-animation.ball-spin></x-animation.ball-spin>
<div class="card" wire:ignore.self>
    <div class="col">
        <div class="d-flex justify-content-between mb-2 mt-4">
            <div class="col-lg-2">
                <a href="{{ route("$role.incentives-&-expenses") }}"
                   class="btn customBg form-control text-white mb-2"><i class="fa fa-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="col-lg-2">
                <input type="text" class="form-control border-1" placeholder="Search" wire:model="searchTerm">

            </div>
        </div>
    </div>
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <form wire:submit.prevent="addIncentive">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <input type="text" placeholder="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   wire:model.defer="incentive.name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-5 form-group">
                            <input type="number" placeholder="₱"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   wire:model.defer="incentive.amount">
                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <button type="submit" class="btn btn-success form-control">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-md-12 table-responsive">
                <table class="table table-hover table-responsive-sm table-responsive-md">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($incentises as $index=>$data)
                        <tr class="">
                            <th scope="row">{{ $incentises->firstItem() + $index }}</th>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->amount }}</td>
                            {{--update delete--}}
                            <td>
                                <a href="" wire:click.prevent="editIncentise({{ $data }})"
                                   class="btn mr-2 bg-primary">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a href="" wire:click.prevent="confirmIncentiseRemoval('{{ $data->id }}')"
                                   class="btn bg-danger">
                                    <i class="fa fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="6"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end" style="">
            {{ $incentises->onEachSide(0)->links() }}
        </div>
    </div>
</div>
<x-modals.incentise/>
