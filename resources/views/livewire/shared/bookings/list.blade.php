<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                <a href="{{ route($role.'.add-booking') }}"
                   class="btn customBg text-white"><i class="fa fa-plus-circle mr-1"></i>
                    {{ auth()->user()->role_id == \App\Models\User::ROLE_ADMIN? 'Add booking' : 'Request booking' }}
                </a>
                @if($selectedRows)
                    <div class="btn-group p-1">
                        <button type="button" class="btn btn-default">Bulk Action</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="#" wire:click.prevent="confirmSelectedBookingRemoval">Deleted Selected</a>
                        </div>
                    </div>
                    <span>Selected {{ count($selectedRows) }} {{ Str::plural('booking', count($selectedRows)) }}</span>
                @endif
            </div>
            {{--                            <div class="">--}}
            {{--                                <input type="text" class="form-control border-0" placeholder="Search" wire:model.defer="searchTerm">--}}
            {{--                                <div class="" wire:loading.delay wire:target="searchTerm">--}}
            {{--                                    <div class="la-ball-clip-rotate la-dark la-sm" >--}}
            {{--                                        <div></div>--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                @if (\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{!! \Session::get('success') !!}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif

                <table class="table table-hover table-responsive-sm
                                 table-responsive-lg">

                    <thead>
                    <tr>
                        @if(count($bookings) != 0)
                            <th>
                                <div class="icheck-orange d-inline">
                                    <input type="checkbox" value="" name="todo1" id="todoCheck2" wire:model="selectedPageRows">
                                    <label for="todoCheck2"></label>
                                </div>
                            </th>
                        @endif
                        <th scope="col">#</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Trip from</th>
                        <th>Trip to</th>
                        <th>Distance</th>
                        <th>Driver</th>
                        <th>Trip status</th>
                        <th>Date Created</th>
                        <th>Actions</th>

                    </tr>
                    </thead>


                    <tbody wire:loading.class="text-muted">
                    @forelse($bookings as $index => $booking)

                        <tr class="">
                            <th>
                                <div class="icheck-orange d-inline ">
                                    <input wire:model="selectedRows" type="checkbox" value="{{ $booking->id }}" name="todo2" id="{{ $booking->id }}" >
                                    <label for="{{ $booking->id }}"></label>
                                </div>
                            </th>
                            <th scope="row">{{ $bookings->firstItem() + $index }}</th>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->vehicle->name?? 'pending' }}</td>
                            <td>{{ $booking->t_trip_start }}</td>
                            <td>{{ $booking->t_trip_end }}</td>
                            <td>{{ $booking->t_total_distance }}</td>
                            <td>{{ $booking->driver->name?? 'pending' }}</td>
                            <td>
                               @if(auth()->user()->role_id==\App\Models\User::ROLE_ADMIN)
                                    <select class="badge badge-{{$booking->statusTypeBadge}}"
                                            wire:change="changeStatus({{ $booking  }},$event.target.value)"
                                    >
                                        @foreach($trip_status as $data)
                                            <option value="{{ $data->id }}" @if($data->id == $booking->trip_status_id) selected @endif>{{ $data->name }}</option>
                                        @endforeach

                                    </select>
                                @else
                                    <span class="badge badge-{{$booking->statusTypeBadge}}">
                                    {{ $booking->status->name }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $booking->created_at->toFormattedDateTime() }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a type="button" href="{{ route("$role.booking-details", $booking->id) }}" class="btn btn-outline-success"
                                    ><i
                                            class="fa fa-eye mr-1"></i> View</a>
                                    <button type="button"
                                            class="btn  btn-outline-secondary  dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="{{ route("$role.booking-details", $booking->id) }}"
                                        >
                                            <i class="fa fa-eye text-success ml-2"></i> View
                                        </a>
                                        @if(auth()->user()->role_id == \App\Models\User::ROLE_CLIENT)
                                            @if($booking->trip_status_id == \App\Models\TripStatus::PENDING)
                                                <a href="{{ route("$role.update.bookings", $booking) }}" class="dropdown-item">
                                                    <i class="fa fa-edit text-primary ml-2"></i> Edit
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route("$role.update.bookings", $booking) }}" class="dropdown-item">
                                                <i class="fa fa-edit text-primary ml-2"></i> Edit
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a href="" class="dropdown-item" wire:click.prevent="confirmUserRemoval('{{ $booking->id }}')">
                                            <i class="fa fa-trash text-danger ml-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-custom.empty colSpan="10"></x-custom.empty>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end"  style="">
                {{ $bookings->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
