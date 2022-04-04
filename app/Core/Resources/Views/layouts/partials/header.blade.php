<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            @include ('core::layouts.partials.header.header-logo')
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <span class="iconify" data-icon="mdi:backburger"></span>
            </button>
            @include ('core::layouts.partials.header.search-inline')
        </div>

        <div class="d-flex">
            @include ('core::layouts.partials.header.search-mobile')
            @if(Permission::has('admin.setting.store'))
            <div class="dropdown d-inline-block">
                <!-- setting trigger button -->
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <span class="iconify" data-icon="ant-design:setting-outlined"></span>
                </button>
            </div>
            @endif
            @include ('core::layouts.partials.header.user-dropdown')
        </div>
    </div>
</header>