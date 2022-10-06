<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                <button wire:click.prevent="addNew" class="btn-sm customBg text-white">
                    <i class="fa fa-plus-circle mr-1"></i>Add vehicle
                </button>
                @if($selectedRows)
                    <div class="btn-group p-1">
                        <button type="button" class="btn btn-default">Bulk Action</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="#" wire:click.prevent="markAsActive">Mark as Active</a>
                            <a class="dropdown-item" href="#" wire:click.prevent="markAsInactive">Mark as Inactive</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" wire:click.prevent="confirmSelectedUserRemoval">Deleted Selected</a>
                        </div>
                    </div>
                    <span>Selected {{ count($selectedRows) }} {{ Str::plural('driver', count($selectedRows)) }}</span>
                @endif
            </div>
            <div class="">
                <input type="text" class="form-control border-0" placeholder="Search" wire:model="searchTerm">
                <div class="" wire:loading.delay wire:target="searchTerm">
                    <div class="la-ball-clip-rotate la-dark la-sm" >
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover  table-responsive-md">
                    <thead>
                    <tr>
                        <th>
                            @if(count($vehicles) != 0)
                                <div class="icheck-orange d-inline">
                                    <input type="checkbox" value="" name="todo1" id="todoCheck2"
                                           wire:model="selectedPageRows">
                                    <label for="todoCheck2"></label>
                                </div>
                            @endif
                        </th>
                        <th scope="col">#</th>
                        <th scope="col"> Vehicle Name</th>
                        <th scope="col">Registration Number</th>
                        <th scope="col">Model</th>
                        <th scope="col">Chassis No</th>
                            <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>

                    <tbody wire:loading.class="text-muted">
                    @forelse($vehicles as $index => $vehicle)
                        <tr class="">
                            <th>
                                <div class="icheck-orange d-inline">
                                    <input wire:model="selectedRows" type="checkbox"
                                           value="{{ $vehicle->id }}" name="todo2"
                                           id="{{ $vehicle->id }}">
                                    <label for="{{ $vehicle->id }}"></label>
                                </div>
                            </th>
                            <th scope="row">{{ $vehicles->firstItem() + $index }}</th>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->registration_number }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->chassis_no }}</td>
                            <td>
                                <select class="badge badge-{{$vehicle->statusTypeBadge}}"
                                        wire:change="changeVehicleStatus({{ $vehicle }},$event.target.value)"
                                >
                                    @foreach($status as $data)
                                        <option value="{{ $data->id }}" @if($data->id == $vehicle->status_id) selected @endif>{{ strtoupper($data->name) }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-outline-success"
                                       wire:click.prevent="view({{ $vehicle }})"><i
                                            class="fa fa-eye mr-1"></i> View</a>
                                    <button type="button"
                                            class="btn  btn-outline-secondary  dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="#"
                                           wire:click.prevent="view({{ $vehicle }})">
                                            <i class="fa fa-eye text-success ml-2"></i> View
                                        </a>
                                        <a href="" class="dropdown-item"
                                           wire:click.prevent="editVehicle({{ $vehicle }})">
                                            <i class="fa fa-edit text-primary ml-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="" class="dropdown-item"
                                           wire:click.prevent="confirmVehicleRemoval('{{ $vehicle->id }}')">
                                            <i class="fa fa-trash text-danger ml-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                       <x-custom.empty colSpan="8"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end" style="">
                {{ $vehicles->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
    {{--vehicle modal--}}
    <x-modals.vehicle :isView="$viewMode"></x-modals.vehicle>
</div>


