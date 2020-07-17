<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <img alt="image" class="rounded-circle" src="{{URL::asset('theme/img/profile_small.jpg')}}"/>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                    <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                    <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                    <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="login.html">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                <img class="absolute2" src="{{URL::asset('theme/img/yems/asset-1.png')}}" alt="">
            </div>
        </li>
        <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
        </li>
        <li>
            <div class="nav-label text-white p-3 mt-2">Modules</div>
        </li>
        <li class="{{ request()->is('gate/*') ? 'active' : '' }}">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Configuration</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @can('viewAny', Modules\Gate\Entities\User::class)
                <li class="{{ (request()->is('gate/user') || request()->is('gate/user/*')) ? 'active' : '' }}">
                    <a href="{{ route('gate.user.index')}}"><i class="fa fa-user-circle-o"></i> <span class="nav-label">User</span></a>
{{--                    <ul class="nav nav-second-level">--}}
{{--                        <li class="{{ request()->is('gate/user*') ? 'active' : '' }}"><a href="{{ route('gate.user.index')}}">Data</a></li>--}}
{{--                    </ul>--}}
                </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\Company::class)
                    <li class=" {{ (request()->is('gate/company') || request()->is('gate/company/*')) ? 'active' : '' }}">
                        <a href="{{ route('gate.company.index')}}"><i class="fa fa-building-o"></i> <span class="nav-label">Company</span></a>
                    </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\Role::class)
                    <li class="{{ (request()->is('gate/role') || request()->is('gate/role/*')) ? 'active' : '' }}">
                        <a href="{{route('gate.role.index')}}"><i class="fa fa-users"></i> <span class="nav-label">Role</span></a>
                    </li>
                @endcan
                @can('viewAny', Modules\Gate\Entities\RoleMenu::class)
                    <li class="{{ (request()->is('gate/role-menu') || request()->is('gate/role-menu/*')) ? 'active' : '' }}">
                        <a href="{{route('gate.role-menu.index')}}"><i class="fa fa-list-alt"></i> <span class="nav-label">Role Menu</span></a>
                    </li>
                @endcan
            </ul>
        </li>

        <li class=" {{ request()->is('gate/test*') ? 'active' : '' }}">
            <a href="{{ route('gate.test.index')}}"><i class="fa fa-th-list"></i> <span class="nav-label">Testing</span></a>
        </li>
    </ul>
</div>
