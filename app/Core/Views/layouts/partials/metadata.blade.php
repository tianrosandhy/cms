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
<!-- Plugin CSS -->
<link href="{{ admin_asset('css/app-plugins-compiled.css') }}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ admin_asset('css/additional.css') }}">

@if(isset($custom_css))
<link rel="stylesheet" href="{{ $custom_css }}">
@endif

<script src="{{ admin_asset('libs/jquery/jquery.min.js') }}"></script>

@stack ('style')