<!-- Vendor js -->
<script src="{{ admin_asset('js/vendor.min.js') }}"></script>
<script src="{{ admin_asset('js/app.js') }}"></script>
<script src="{{ admin_asset('libs/toastr/toastr.min.js') }}"></script>
<script src="{{ admin_asset('libs/switchery/js/switchery.min.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ admin_asset('js/additional.js') }}"></script>
<script>
var BASE_URL = '{{ admin_url('/') }}';
var SITE_URL = '{{ url('/') }}';
var STORAGE_URL = '{{ Storage::url('/') }}';
var CSRF_TOKEN = '{{ csrf_token() }}';
</script>
@include ('core::layouts.include.error-management')
{!! Media::assets() !!}
@stack ('script')
@yield ('datatable_script')