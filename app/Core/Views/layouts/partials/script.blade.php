<!-- Vendor js -->
<script src="{{ admin_asset('js/vendor.min.js') }}"></script>
<script src="{{ admin_asset('js/app.min.js') }}"></script>
<script src="{{ admin_asset('libs/toastr/toastr.min.js') }}"></script>
@include ('core::layouts.include.error-management')
@stack ('script')