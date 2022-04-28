<meta charset="utf-8" />
<title>{{ isset($title) ? $title .' - ' . setting('general.title') : setting('general.title') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="{{ setting('general.favicon', admin_asset('images/logo.png')) }}">
{!! Autocrud::css() !!}

<link href="{{ asset('themes/sash/assets/plugins/toastr/toastr.css') }}" rel="stylesheet" />
<link href="{{ asset('themes/sash/assets/css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('themes/sash/assets/css/skin-modes.css') }}" rel="stylesheet" />
<link href="{{ asset('themes/sash/assets/css/additional.css') }}" rel="stylesheet" />

@if(isset($custom_css))
<link rel="stylesheet" href="{{ $custom_css }}">
@endif

<script src="{{ asset('core/js/jquery.min.js') }}"></script>
@stack ('style')