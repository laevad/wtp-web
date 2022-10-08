<x-animation.ball-spin></x-animation.ball-spin>
@if(url()->previous() == route($role.'.booking-list'))
    <a href="{{ route("$role.booking-list") }}" class="btn customBg text-white mb-2"><i class="fa fa-arrow-left mr-1"></i>Booking list</a>
@endif
<div class="row">
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body">
                @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                    <div class="mt-2 mb-3">
                        <a href="#" class="btn btn-sm btn-success" wire:click.prevent="addExpenses">Trip
                            Expense</a>
                        <a href="#" class="btn btn-sm btn-success"
                           wire:click.prevent="addIncentive">Incentive</a>
                    </div>
                @endif
                <div class="text-muted">
                    @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                        <p class="text-sm">Customer Info
                            <b class="d-block">{{ $booking->user->name }}</b>
                            <b class="d-block">{{ $booking->user->number }}</b>
                            <b class="d-block">{{ $booking->user->email }}</b>
                            <b class="d-block">{{ $booking->user->address }} </b>
                        </p>
                    @endif
                    <p class="text-sm">Driver Info
                        <b class="d-block">{{ $booking->driver->name ?? 'N/A' }}</b>
                        <b class="d-block">{{ $booking->driver->number?? '' }}</b>
                        <b class="d-block">{{ $booking->driver->address ?? '' }}</b>
                    </p>
                    <p class="text-sm">Vehicle Info
                        <b class="d-block">{{ $booking->vehicle->name ?? 'N/A' }}</b>
                        <b class="d-block">{{ $booking->vehicle->model ?? '' }}</b>
                    </p>

                        @if($booking->status->id != \App\Models\TripStatus::PENDING)
                            <p class="text-sm">Tracking URL
                            <b class="d-block"><a target="_new" href="{{ route("$role.tracking", $booking) }}">{{ route("$role.tracking", $booking) }}</a></b>
                            </p>
                        @endif




                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="card card-success card-outline">
            <div class="card-body">
                <h4>Overview:</h4>
                <div class="post">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="user-block">
                                <span class="username">{{ $booking->t_trip_start }}</span>
                                <span class="description">{{ $booking->trip_start_date  }}</span>
                            </div>
                        </div>
                        to
                        <div class="col-lg-5">
                            <div class="user-block">
                                <span class="username">{{ $booking->t_trip_end }}</span>
                                <span class="description">{{ $booking->trip_end_date }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-5">
                            <div class="user-block">
                                             <span class="description-header mr-2">Trip Status: <span class="badge badge-{{ $booking->status_type_badge }}">{{ $booking->status->name }}</span>
                                             </span>
                                <span
                                    class="description-header d-block">Distance: <strong>{{ $booking->t_total_distance }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                    <div class="post">
                        <div class="row">
                            <h5>Trip Expense:</h5>
                            <table class="table table-hover table-responsive-sm ">
                                <thead>
                                <tr class="text-muted">
                                    <th scope="col">#</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                    <th>Date</th>
                                    <th>Added On</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($expenses as $index=> $data)
                                    <tr class="text-muted">
                                        <th scope="row">{{ ($expenses->firstItem() + $index) }}</th>
                                        <td class="">{{ $data->amount  }}</td>
                                        <td class="">{{ $data->note == null ? 'N/A' : $data->note  }}</td>
                                        <td>{{  $data->date }}</td>
                                        <td class="">{{ $data->created_at->toFormattedDateTime()  }}</td>
                                        <th>
                                            <a href="" wire:click.prevent="confirmExpenseRemoval('{{ $data->id }}')">
                                                <i class="fa fa-trash text-danger ml-2"></i>
                                            </a>
                                        </th>
                                    </tr>
                                @empty
                                    <x-custom.empty colSpan="6"></x-custom.empty>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="post">
                        <div class="row">
                            <h5>Incentive: </h5>
                            <table class="table table-hover table-responsive-sm ">
                                <thead>
                                <tr class="text-muted">
                                    <th scope="col">#</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                    <th>Date</th>
                                    <th>Added On</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse($incentives as $index=> $data)
                                    <tr class="text-muted">
                                        <th scope="row">{{ $incentives->firstItem() + $index }}</th>
                                        <td class="">{{ $data->amount  }}</td>
                                        <td class="">{{ $data->note == null ? 'N/A' : $data->note  }}</td>
                                        <td>{{  $data->date }}</td>
                                        <td class="">{{ $data->created_at->toFormattedDateTime()  }}</td>
                                        <th>
                                            <a href="" wire:click.prevent="confirmIncentiveRemoval('{{ $data->id }}')">
                                                <i class="fa fa-trash text-danger ml-2"></i>
                                            </a>
                                        </th>
                                    </tr>
                                @empty
                                    <x-custom.empty colSpan="6"></x-custom.empty>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
            <div class="card-footer d-flex justify-content-end" style="">
                {{ $incentives->onEachSide(0)->links() }}
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<x-modals.view-booking :booking="$booking" :isIncentive="$isIncentive" ></x-modals.view-booking>
