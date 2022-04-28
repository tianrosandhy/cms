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
                                LOGIN
                            </span>
                            <p class="text-center text-uppercase">{{ setting('general.title') }}</p>
                            <div class="panel panel-primary">
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    @csrf
                                    <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="iconify" data-icon="uim:user-md"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" type="email" placeholder="your@email.com" name="email" maxlength="100">
                                    </div>
                                    <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="iconify" data-icon="bi:key-fill" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 form-control ms-0" type="password" placeholder="Password" name="password" maxlength="100">
                                    </div>

                                    
                                    <div class="pt-2 form-group">
                                        <label>
                                            <input type="checkbox" class="" name="remember" value="1">
                                            <span class="custom-control-label">{{ __('core::module.login.remember_me') }}</span>
                                        </label>
                                    </div>
                                    <div class="text-end pt-4">
                                        <p class="mb-0"><a href="#forgot-password-modal" data-bs-toggle="modal" class="text-primary ms-1">Forgot Password?</a></p>
                                    </div>
                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn btn-primary">Log In</button>
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

    <div class="modal fade" id="forgot-password-modal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.forgot-password') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('core::module.login.forgot_password') }}</h5>
                        <button type="button" class="close btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('core::module.login.forgot_description') }}</p>
                        <input type="email" name="email" class="form-control" placeholder="your@email.com">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">{{ __('core::module.form.close') }}</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>        

    @include ('themes::partials.script')
</body>
</html>