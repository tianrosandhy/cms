<meta charset="utf-8" />
<title>{{ isset($title) ? $title : '' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="shortcut icon" href="{{ admin_asset('assets/images/favicon.ico') }}">

<link href="{{ admin_asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ admin_asset('libs/toastr/toastr.min.css') }}">
<link href="{{ admin_asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('css/additional.css') }}" rel="stylesheet" type="text/css" />
@stack ('style')