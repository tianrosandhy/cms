<!DOCTYPE html>
<html lang="{{ Autocrud::currentLang() }}">
<head>
	@include ('themes::partials.metadata')
</head>
<body data-topbar="colored">
    <div id="page-loader">
        <span class="iconify" data-icon="eos-icons:bubble-loading"></span>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include ('themes::partials.header')
        @include ('themes::partials.sidebar')        

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
            @include ('themes::partials.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include ('themes::partials.sidebar.global-setting')
    @include ('themes::partials.modal')
	@include ('themes::partials.script')
</body>
</html>