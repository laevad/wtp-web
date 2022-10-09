<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="WT&P Forwarding Services Inc."
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light "
              style="font-size: 70%;">{{ config('app.name', 'WT&P Management System') }} </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->avatar_url }}" id="profileImage" class="img-circle elevation-2" alt="User Image1" >
            </div>
            <div class="info">
                <a href="#" class="d-block" x-ref="username">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{--Custom nav--}}
                <x-nav.item icon="fa-tachometer-alt" currentPage="dashboard"></x-nav.item>
                @if(auth()->user()->role_id==\App\Models\User::ROLE_ADMIN)
                    <x-nav.item icon="fa-users" currentPage="clients"></x-nav.item>
                    <x-nav.item icon="fa-user-secret" currentPage="drivers"></x-nav.item>
                    <x-nav.item icon="fa-truck" currentPage="vehicles"></x-nav.item>

                @endif
                @if(auth()->user()->role_id == \App\Models\User::ROLE_ADMIN)
                    <x-nav.item icon="fa-road" currentPage="bookings" :treeNav="['booking-list'=>'fa-clipboard-list','add-booking'=>'fa-plus']" isTree="true"></x-nav.item>
                @else
                    <x-nav.item icon="fa-road" currentPage="bookings" :treeNav="['booking-list'=>'fa-clipboard-list','request-booking'=>'fa-plus']" isTree="true"></x-nav.item>
                @endif
                @if(auth()->user()->role_id==\App\Models\User::ROLE_ADMIN)
                    <x-nav.item icon="fa-truck" currentPage="incentives-&-expenses"></x-nav.item>
                    <x-nav.item icon="fa-calculator" currentPage="Reports" :treeNav="['booking-report'=>'fa-file-download','expenses-&-incentives'=>'fa-file-download']" isTree="true"></x-nav.item>
{{--                    <x-nav.item icon="fa-map-pin" currentPage="tracking"></x-nav.item>--}}
                    @endif

                <x-nav.item icon="fa-wrench" currentPage="settings"></x-nav.item>
               <li class="nav-item">
                   <form action="{{ route('logout') }}" method="POST">
                       @csrf
                       <a href="{{ route('logout') }}" class="nav-link"  onclick="event.preventDefault(); this.closest('form').submit();">
                           <i class="nav-icon fas fa-sign-out-alt"></i>
                           <p>Logout</p>
                       </a>
                   </form>
               </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
