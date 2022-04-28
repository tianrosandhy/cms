<!DOCTYPE html>
<html lang="en">
    <head>
        @include ('themes::partials.metadata')
    </head>
    <body class="app sidebar-mini ltr">

        <div class="login-img">
            <div id="global-loader">
                <img src="{{ asset('themes/sash/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
            </div>

            <!-- PAGE -->
            <div class="page">
                <div class="">
                    <!-- CONTAINER OPEN -->
                    <div class="container-login100">
                        <div class="wrap-login100 p-6">
                            @yield ('content')
                        </div>
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!-- End PAGE -->   
        </div>

        @include ('themes::partials.script')
    </body>
</html>