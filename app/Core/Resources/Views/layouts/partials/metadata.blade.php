<meta charset="utf-8" />
<title>{{ isset($title) ? $title .' - ' . setting('general.title') : setting('general.title') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="{{ setting('general.favicon', admin_asset('images/logo.png')) }}">
{!! Autocrud::css() !!}
<link href="{{ asset('themes/'.config('cms.admin.themes', 'xoric').'/style.css') }}" rel="stylesheet" type="text/css" />
@if(isset($custom_css))
<link rel="stylesheet" href="{{ $custom_css }}">
@endif

<script src="{{ asset('core/js/jquery.min.js') }}"></script>
@stack ('style')