<!DOCTYPE html>
<html lang="{{ Autocrud::currentLang() }}">
<head>
	@include ('core::layouts.partials.metadata')
</head>
<body data-topbar="colored">
    <div id="page-loader">
        <span class="iconify" data-icon="eos-icons:bubble-loading"></span>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include ('core::layouts.partials.header')
        @include ('core::layouts.partials.sidebar')        

        <div class="main-content">
            <div class="page-content">
            	@include ('core::components.header-box')
                <div class="page-content-wrapper">
                    <div class="container-fluid">
                    @yield ('content')
                    </div>
                </div>
            </div>
            <!-- End Page-content -->
            @include ('core::layouts.partials.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include ('core::layouts.partials.sidebar.global-setting')
    @include ('core::layouts.partials.modal')
	@include ('core::layouts.partials.script')
</body>
</html>