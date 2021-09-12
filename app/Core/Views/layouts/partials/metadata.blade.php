<meta charset="utf-8" />
<title>{{ isset($title) ? $title .' - ' . setting('general.title') : setting('general.title') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="{{ setting('general.favicon', admin_asset('images/logo.png')) }}">

<!-- Bootstrap Css -->
<link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ admin_asset('css/icon-mdi.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ admin_asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Plugins -->
<link href="{{ admin_asset('libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ admin_asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
<link href="{{ admin_asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ admin_asset('libs/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ admin_asset('libs/select2/select2.min.css') }}">
<link href="{{ admin_asset('libs/switchery/css/switchery.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ admin_asset('css/additional.css') }}">


@if(isset($custom_css))
<link rel="stylesheet" href="{{ $custom_css }}">
@endif

@stack ('style')