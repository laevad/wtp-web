<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                <button wire:click.prevent="addNew" class="btn-sm customBg text-white"><i class="fa fa-plus-circle mr-1"></i>Add client</button>
                @if($selectedRows)
                    <div class="btn-group p-1">
                        <button type="button" class="btn btn-default">Bulk Action</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="#" wire:click.prevent="confirmSelectedUserRemoval">Deleted Selected</a>
                        </div>
                    </div>
                    <span>Selected {{ count($selectedRows) }} {{ Str::plural('client', count($selectedRows)) }}</span>
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
                        <th>Mobile</th>
                        <th>Status</th>
                        <th scope="col">Registered Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>

                    <tbody wire:loading.class="text-muted">
                    @forelse($users as $index => $user)
                        <tr class="">
                            <th> <div class="icheck-orange d-inline">
                                    <input wire:model="selectedRows" type="checkbox" value="{{ $user->id }}" name="todo2" id="{{ $user->id }}" >
                                    <label for="{{ $user->id }}"></label>
                                </div></th>
                            <th scope="row">{{ $users->firstItem() + $index }}</th>
                            <td>
                                <img src="{{ $user->avatar_url }}" class="img img-circle img-thumbnail elevation-1 shadow mr-2" alt="" STYLE="width: 50px">
                                {{ $user->name }}</td>
                            <td class="">{{ $user->email }}</td>
                            <td class="">{{ $user->mobile }}</td>
{{--                            <td><span class="badge @if($user->status=='active') badge-success @else badge-danger @endif">{{ $user->status }}</span></td>--}}
                            <td>
                                <select class="badge badge-{{$user->statusTypeBadge}}"
                                        wire:change=""
                                >
                                    @foreach($status as $data)
                                        <option value="{{ $user->status_id }}" @if($data->id == $user->status_id) selected @endif>{{ strtoupper($data->name) }}</option>
                                    @endforeach

                                </select>
                            </td>
                            <td>{{ $user->created_at->toFormattedDate() }}</td>

                            <td>
                                <a href="" wire:click.prevent="edit({{ $user }})">
                                    <i class="fa fa-edit ml-2"></i>
                                </a>
                                <a href="" wire:click.prevent="confirmUserRemoval('{{ \str($user->id) }}')">
                                    <i class="fa fa-trash text-danger ml-2"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="7"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end"  style="">
                {{ $users->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
    {{--Modal for client--}}
    <x-modals.client :isEdit="$showEditModal" :photo="$photo" :state="$state"></x-modals.client>
</div>
