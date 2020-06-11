<!-- Vendor js -->
<script src="{{ admin_asset('js/vendor.min.js') }}"></script>
<script src="{{ admin_asset('js/app.min.js') }}"></script>
<script src="{{ admin_asset('libs/toastr/toastr.min.js') }}"></script>
<script src="{{ admin_asset('js/additional.js') }}"></script>
<script>
var BASE_URL = '{{ admin_url('/') }}';
var SITE_URL = '{{ url('/') }}';
var STORAGE_URL = '{{ Storage::url('/') }}';
</script>
@include ('core::layouts.include.error-management')
@stack ('script')
