<!doctype html>
<html lang="{{ Autocrud::currentLang() }}">
<head>
    @include ('themes::partials.metadata')
</head>

<body class="app sidebar-mini ltr">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('themes/sash/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            @include ('themes::partials.header')
            @include ('themes::partials.sidebar')

            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">
                        <div class="header-box my-3">
                            @include ('core::components.header-box')
                        </div>
                        @yield ('content')
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!--app-content closed-->
        </div>
        @include ('themes::partials.footer')
    </div>

    @include ('themes::partials.modal')
    @include ('themes::partials.sidebar.global-setting')

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    @include ('themes::partials.script')
</body>

</html>