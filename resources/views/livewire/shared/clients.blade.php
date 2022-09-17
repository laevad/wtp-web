<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <div class="">
                <button wire:click.prevent="addNew" class="btn customBg text-white"><i class="fa fa-plus-circle mr-1"></i>Add client</button>
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
            <div class="card-body">
                <table class="table table-hover  table-responsive-md table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div class="icheck-orange d-inline">
                                <input type="checkbox" value="" name="todo1" id="todoCheck2" wire:model="selectedPageRows">
                                <label for="todoCheck2"></label>
                            </div>
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
                        <tr class="text-center">
                            <td colspan="5">
                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="250" height="250" viewBox="0 0 797.5 834.5" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Empty</title><ellipse cx="308.5" cy="780" rx="308.5" ry="54.5" fill="#3f3d56"/><circle cx="496" cy="301.5" r="301.5" fill="#3f3d56"/><circle cx="496" cy="301.5" r="248.89787" opacity="0.05"/><circle cx="496" cy="301.5" r="203.99362" opacity="0.05"/><circle cx="496" cy="301.5" r="146.25957" opacity="0.05"/><path d="M398.42029,361.23224s-23.70394,66.72221-13.16886,90.42615,27.21564,46.52995,27.21564,46.52995S406.3216,365.62186,398.42029,361.23224Z" transform="translate(-201.25 -32.75)" fill="#d0cde1"/><path d="M398.42029,361.23224s-23.70394,66.72221-13.16886,90.42615,27.21564,46.52995,27.21564,46.52995S406.3216,365.62186,398.42029,361.23224Z" transform="translate(-201.25 -32.75)" opacity="0.1"/><path d="M415.10084,515.74682s-1.75585,16.68055-2.63377,17.55847.87792,2.63377,0,5.26754-1.75585,6.14547,0,7.02339-9.65716,78.13521-9.65716,78.13521-28.09356,36.8728-16.68055,94.81576l3.51169,58.82089s27.21564,1.75585,27.21564-7.90132c0,0-1.75585-11.413-1.75585-16.68055s4.38962-5.26754,1.75585-7.90131-2.63377-4.38962-2.63377-4.38962,4.38961-3.51169,3.51169-4.38962,7.90131-63.2105,7.90131-63.2105,9.65716-9.65716,9.65716-14.92471v-5.26754s4.38962-11.413,4.38962-12.29093,23.70394-54.43127,23.70394-54.43127l9.65716,38.62864,10.53509,55.3092s5.26754,50.04165,15.80262,69.356c0,0,18.4364,63.21051,18.4364,61.45466s30.72733-6.14547,29.84941-14.04678-18.4364-118.5197-18.4364-118.5197L533.62054,513.991Z" transform="translate(-201.25 -32.75)" fill="#2f2e41"/><path d="M391.3969,772.97846s-23.70394,46.53-7.90131,48.2858,21.94809,1.75585,28.97148-5.26754c3.83968-3.83968,11.61528-8.99134,17.87566-12.87285a23.117,23.117,0,0,0,10.96893-21.98175c-.463-4.29531-2.06792-7.83444-6.01858-8.16366-10.53508-.87792-22.826-10.53508-22.826-10.53508Z" transform="translate(-201.25 -32.75)" fill="#2f2e41"/><path d="M522.20753,807.21748s-23.70394,46.53-7.90131,48.28581,21.94809,1.75584,28.97148-5.26754c3.83968-3.83969,11.61528-8.99134,17.87566-12.87285a23.117,23.117,0,0,0,10.96893-21.98175c-.463-4.29531-2.06792-7.83444-6.01857-8.16367-10.53509-.87792-22.826-10.53508-22.826-10.53508Z" transform="translate(-201.25 -32.75)" fill="#2f2e41"/><circle cx="295.90488" cy="215.43252" r="36.90462" fill="#ffb8b8"/><path d="M473.43048,260.30832S447.07,308.81154,444.9612,308.81154,492.41,324.62781,492.41,324.62781s13.70743-46.39439,15.81626-50.61206Z" transform="translate(-201.25 -32.75)" fill="#ffb8b8"/><path d="M513.86726,313.3854s-52.67543-28.97148-57.943-28.09356-61.45466,50.04166-60.57673,70.2339,7.90131,53.55335,7.90131,53.55335,2.63377,93.05991,7.90131,93.93783-.87792,16.68055.87793,16.68055,122.90931,0,123.78724-2.63377S513.86726,313.3854,513.86726,313.3854Z" transform="translate(-201.25 -32.75)" fill="#d0cde1"/><path d="M543.2777,521.89228s16.68055,50.91958,2.63377,49.16373-20.19224-43.89619-20.19224-43.89619Z" transform="translate(-201.25 -32.75)" fill="#ffb8b8"/><path d="M498.50359,310.31267s-32.48318,7.02339-27.21563,50.91957,14.9247,87.79237,14.9247,87.79237l32.48318,71.11182,3.51169,13.16886,23.70394-6.14547L528.353,425.32067s-6.14547-108.86253-14.04678-112.37423A33.99966,33.99966,0,0,0,498.50359,310.31267Z" transform="translate(-201.25 -32.75)" fill="#d0cde1"/><polygon points="277.5 414.958 317.885 486.947 283.86 411.09 277.5 414.958" opacity="0.1"/><path d="M533.896,237.31585l.122-2.82012,5.6101,1.39632a6.26971,6.26971,0,0,0-2.5138-4.61513l5.97581-.33413a64.47667,64.47667,0,0,0-43.1245-26.65136c-12.92583-1.87346-27.31837.83756-36.182,10.43045-4.29926,4.653-7.00067,10.57018-8.92232,16.60685-3.53926,11.11821-4.26038,24.3719,3.11964,33.40938,7.5006,9.18513,20.602,10.98439,32.40592,12.12114,4.15328.4,8.50581.77216,12.35457-.83928a29.721,29.721,0,0,0-1.6539-13.03688,8.68665,8.68665,0,0,1-.87879-4.15246c.5247-3.51164,5.20884-4.39635,8.72762-3.9219s7.74984,1.20031,10.062-1.49432c1.59261-1.85609,1.49867-4.559,1.70967-6.99575C521.28248,239.785,533.83587,238.70653,533.896,237.31585Z" transform="translate(-201.25 -32.75)" fill="#2f2e41"/><circle cx="559" cy="744.5" r="43" fill="#6c63ff"/><circle cx="54" cy="729.5" r="43" fill="#6c63ff"/><circle cx="54" cy="672.5" r="31" fill="#6c63ff"/><circle cx="54" cy="624.5" r="22" fill="#6c63ff"/></svg>
                                <p class="mt-2">Empty</p>
                            </td>
                        </tr>
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
