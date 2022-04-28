<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            @include ('themes::partials.header.logo')

            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon fe fe-more-vertical"></span></button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">
{{--
                            @include ('themes::partials.header.dropdown-notification')
                            @include ('themes::partials.header.dropdown-inbox')
--}}                        

                            @if(Permission::has('admin.setting.store'))
                            <div class="dropdown  d-flex notifications">
                                <a class="nav-link icon right-bar-toggle" data-bs-toggle="sidebar-right" data-target=".sidebar-right">
                                    <i class="iconify" data-icon="ant-design:setting-outlined"></i>
                                </a>
                            </div>
                            @endif

                            @include ('themes::partials.header.dropdown-user')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->