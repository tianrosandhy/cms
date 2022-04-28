<!doctype html>
<html lang="{{ Autocrud::currentLang() }}" dir="ltr">
<head>
    @include ('themes::partials.metadata')
</head>
<body class="app sidebar-mini ltr">
    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">
        <!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="{{ asset('themes/sash/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOBAL-LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <?php
                        $wideLogo = setting('general.logo_wide');
                        if(!$wideLogo){
                            $wideLogo = admin_asset('images/wide_logo.png');
                        }            
                        ?>
                        <img src="{{ $wideLogo }}" class="header-brand-img" alt="Icon" style="height:30px;">
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST">
                            <span class="login100-form-title pb-5">
                                RESET PASSWORD
                            </span>
                            <p class="text-center text-uppercase">{{ setting('general.title') }}</p>
                            <div class="panel panel-primary">
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    @csrf
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="iconify" data-icon="bi:key-fill"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" type="password" placeholder="New Password" name="password" maxlength="50">
                                    </div>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="iconify" data-icon="bi:key-fill"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" type="password" placeholder="Repeat New Password" name="password_confirmation" maxlength="50">
                                    </div>

                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn btn-primary">Save New Password</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    @include ('themes::partials.script')
</body>
</html>