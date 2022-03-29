@include ('autocrud::media.assets')
<script>
var AUTOCRUD_STORAGE_URL = '{{ Storage::url('/') }}';
var AUTOCRUD_FILE_MANAGER_URL = '{{ route('autocrud.filemanager') }}';
var AUTOCRUD_MEDIA_UPLOAD_URL = '{{ route('autocrud.media') }}';
var AUTOCRUD_REMOVE_MEDIA_URL = '{{ route('autocrud.media.remove') }}';
var AUTOCRUD_GET_IMAGE_URL = '{{ route('autocrud.media.get-image-url') }}';
var AUTOCRUD_FILE_POST_DOCUMENT_URL = '{{ route('autocrud.post-document') }}';
var AUTOCRUD_FILE_REMOVE_DOCUMENT_URL = '{{ route('autocrud.delete-document') }}';
</script>
@if (config('autocrud.asset_dependency.load_jquery'))
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endif
@if (config('autocrud.asset_dependency.load_bootstrap'))
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endif
@if (config('autocrud.asset_dependency.load_iconify'))
    <script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
@endif
@if (config('autocrud.asset_dependency.load_plugins'))
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'media/media.css') }}">

    <script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'plugins.js') !!}"></script>    
    <script src="{{ asset(config('autocrud.asset_url') . '/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset(config('autocrud.asset_url') . '/tinymce/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset(config('autocrud.asset_url') . '/media/dropzone-input.js') }}"></script>
    <script src="{{ asset(config('autocrud.asset_url') . '/media/media.js') }}"></script>
@endif

<!-- Datatable core assets -->
<link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'datatable/datatables.min.css') }}">
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/DataTables/js/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/Responsive/js/dataTables.responsive.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/FixedHeader/js/dataTables.fixedHeader.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/FixedColumns/js/dataTables.fixedColumns.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/ColReorder/js/dataTables.colReorder.min.js') !!}"></script>

<!-- AutoCRUD specific plugins -->
<script src="{{ asset(config('autocrud.asset_url') . 'autocrud-script.js') }}"></script>