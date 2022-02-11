<!doctype html>
<html lang="en">
  <head>
    @include ('core::layouts.partials.metadata')
  </head>
  <body class="bg-primary bg-pattern">
    <div class="account-pages my-5 pt-sm-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="mt-4 text-center">
              <div class="row justify-content-center">
                <div class="col-md-4 col-6">
                  <img src="{{ admin_asset('images/not-found.png') }}" alt="404" class="img-fluid mx-auto d-block">
                </div>
              </div>
              <h1 class="mt-5 text-uppercase text-white font-weight-bold mb-3">Sorry, Page not Found</h1>
              <h5 class="text-white-50">The page is already missing or the URL inputted is wrong.</h5>
              <div class="mt-5">
                <a class="btn btn-success waves-effect waves-light" href="{{ admin_url('/') }}">Back to Dashboard</a>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
    </div>
    <!-- end Account pages -->
    @include ('core::layouts.partials.script')
  </body>
</html>
