<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                <button wire:click.prevent="addNew" class="btn-sm customBg text-white"><i class="fa fa-plus-circle mr-1"></i>Add driver</button>
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
                <label>
                    <input type="text" class="form-control border-0" placeholder="Search" wire:model="searchTerm">
                </label>
                <div class="" wire:loading.delay wire:target="searchTerm">
                    <div class="la-ball-clip-rotate la-dark la-sm" >
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-responsive-sm table-responsive-md ">
                    <thead>
                    <tr>
                        <th>
                            @if(count($users) != 0)
                                <div class="icheck-orange d-inline">
                                    <input type="checkbox" value="" name="todo1" id="todoCheck2"
                                           wire:model="selectedPageRows">
                                    <label for="todoCheck2"></label>
                                </div>
                            @endif
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Name
                            <span class="float-right" style="cursor: pointer" wire:click="sortedBy('name')">
                                            <i class="fa fa-arrow-up {{ $sortColumnName == 'name' && $sortDirection == 'asc' ? '' : 'text-muted' }}"></i>
                                        <i class="fa fa-arrow-down {{ $sortColumnName == 'name' && $sortDirection == 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                        </th>
                        <th scope="col">Email
                            <span class="float-right" style="cursor: pointer" wire:click="sortedBy('email')">
                                            <i class="fa fa-arrow-up {{ $sortColumnName == 'email' && $sortDirection == 'asc' ? '' : 'text-muted' }}"></i>
                                        <i class="fa fa-arrow-down {{ $sortColumnName == 'email' && $sortDirection == 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                        </th>
                        <th scope="col">License No</th>
                        <th scope="col">License Exp Date</th>
                        <th scope="col">Date of Joining</th>
                        <th scope="col">Is Active</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>

                    <tbody wire:loading.class="text-muted">
                    @forelse($users as $index => $user)
                        <tr class="">
                            <th>
                                <div class="icheck-orange d-inline">
                                    <input wire:model="selectedRows" type="checkbox" value="{{ $user->id }}" name="todo2" id="{{ $user->id }}" >
                                    <label for="{{ $user->id }}"></label>
                                </div>
                            </th>
                            <th scope="row">{{ $users->firstItem() + $index }}</th>
                            <td>
                                <img src="{{ $user->avatar_url }}" class="img img-circle img-thumbnail elevation-1 shadow mr-2" alt="" STYLE="width: 50px">
                                {{ $user->name }}</td>
                            <td class="">{{ $user->email }}</td>
                            <td class="">{{ $user->license_number }}</td>
                            <td>{{ $user->license_expiry_date }}</td>
                            <td>{{ $user->date_of_joining }}</td>
                            <td>
                                <select class="badge badge-{{$user->statusTypeBadge}}"
                                        wire:change="changeUserStatus({{ $user }},$event.target.value)"
                                >
                                    @foreach($status as $data)
                                        <option value="{{ $data->id }}" @if($data->id == $user->status_id) selected @endif>{{ strtoupper($data->name) }}</option>
                                    @endforeach

                                </select>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-outline-secondary" wire:click.prevent="view({{ $user }})"><i class="fa fa-eye mr-1"></i> View</a>
                                    <button type="button" class="btn  btn-outline-secondary  dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="#" wire:click.prevent="view({{ $user }})">
                                            <i class="fa fa-eye text-success ml-2"></i> View
                                        </a>
                                        <a href="" class="dropdown-item" wire:click.prevent="edit({{ $user }})">
                                            <i class="fa fa-edit text-primary ml-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="" class="dropdown-item" wire:click.prevent="confirmUserRemoval({{ $user->id }})">
                                            <i class="fa fa-trash text-danger ml-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="9"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end"  style="">
                {{ $users->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
    {{--modal driver--}}
    <x-modals.driver :isEdit="$showEditModal" :isView="$viewMode" :photo="$photo" :state="$state"></x-modals.driver>
</div>
