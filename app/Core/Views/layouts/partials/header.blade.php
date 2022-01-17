<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            @include ('core::layouts.partials.header.header-logo')
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-backburger"></i>
            </button>
            @include ('core::layouts.partials.header.search-inline')
        </div>

        <div class="d-flex">
            @include ('core::layouts.partials.header.search-mobile')
            @include ('core::layouts.partials.header.language-toggle')
            @if(Permission::has('admin.setting.store'))
            <div class="dropdown d-inline-block">
                <!-- setting trigger button -->
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-tune"></i>
                </button>
            </div>
            @endif
            @include ('core::layouts.partials.header.user-dropdown')
        </div>
    </div>
</header>