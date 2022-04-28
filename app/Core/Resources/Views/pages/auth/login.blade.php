<!DOCTYPE html>
<html lang="en">
    <head>
        @include ('themes::partials.metadata')
    </head>

    <body class="authentication-bg bg-primary bg-pattern">
        
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-8">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="mx-auto mb-5">
                                    @include ('themes::include.logo', ['height' => 50])
                                </div>

                                <h6 class="h5 mb-0 mt-4">{{ __('core::module.login.h1') }}</h6>
                                <p class="text-muted mt-1 mb-4">{{ __('core::module.login.h2') }}</p>

                                <form action="#" class="authentication-form" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text bg-white">
                                                <span class="iconify" data-icon="uim:user-md"></span>
                                            </span>
                                            <input type="email" class="form-control" id="email" placeholder="your@email.com" name="email">
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label class="form-control-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text bg-white">
                                                <span class="iconify" data-icon="bi:key-fill"></span>
                                            </span>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Enter your password" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="checkbox-signin" checked name="remember" value="1">
                                            <label class="custom-control-label" for="checkbox-signin">{{ __('core::module.login.remember_me') }}</label>
                                            <a href="#" class="float-end text-muted text-unline-dashed ml-1" data-toggle="modal" data-target="#forgot-password-modal">{{ __('core::module.login.forgot_password') }}</a>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary d-block font-weight-bold" type="submit"><span class="iconify" data-icon="bi:key-fill"></span> LOG IN
                                        </button>
                                    </div>
                                </form>                                
                                
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

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