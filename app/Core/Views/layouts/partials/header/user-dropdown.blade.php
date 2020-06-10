<li class="dropdown notification-list align-self-center profile-dropdown d-block">
    <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <div class="media user-profile ">
            <img src="{{ admin_asset('images/default-user.png') }}" alt="user-image" class="rounded-circle align-self-center" />
            <div class="media-body text-left">
                <h6 class="pro-user-name ml-2 my-0">
                    <span>{{ $user->name }}</span>
                    <span class="pro-user-desc text-muted d-block mt-1">{{ $role->name }} </span>
                </h6>
            </div>
            <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
        </div>
    </a>
    <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
        <a href="{{ route('admin.my-profile') }}" class="dropdown-item notify-item">
            <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
            <span>My Profile</span>
        </a>
        <div class="dropdown-divider"></div>

        <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
            <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
            <span>Logout</span>
        </a>
    </div>
</li>