<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <img alt="image" class="rounded-circle" src="{{URL::asset('theme/img/profile_small.jpg')}}"/>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">David Williams</span>
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
                IN+
            </div>
        </li>
        <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
        </li>
        <li>
            <div class="nav-label text-white p-3 mt-2">Gate</div>
        </li>
        <li class="{{ request()->is('gate/user*') ? 'active' : '' }}">
            <a href="{{ route('gate.user.index')}}"><i class="fa fa-user-o"></i> <span class="nav-label">User</span></a>
        </li>
        <li class=" {{ request()->is('gate/company*') ? 'active' : '' }}">
            <a href="{{ route('gate.company.index')}}"><i class="fa fa-th-list"></i> <span class="nav-label">Company</span></a>
        </li>
        <li class="">
            <a href=""><i class="fa fa-address-card-o"></i> <span class="nav-label">Role</span></a>
        </li>
        <li class="">
            <a href=""><i class="fa fa-id-badge"></i> <span class="nav-label">Role Menu</span></a>
        </li>
        <li class=" {{ request()->is('gate/test*') ? 'active' : '' }}">
            <a href="{{ route('gate.test.index')}}"><i class="fa fa-th-list"></i> <span class="nav-label">Testing</span></a>
        </li>
        <li>
            <div class="nav-label text-white p-3 mt-2">Master</div>
        </li>
    </ul>
</div>