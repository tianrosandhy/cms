@if (config('autocrud.asset_dependency.load_bootstrap'))
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endif
@if (config('autocrud.asset_dependency.load_plugins'))
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'media/media.css') }}">
@endif
<!-- Datatable core asset -->
<link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'autocrud.css') }}">
