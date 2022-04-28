<script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>

{!! Autocrud::js() !!}

<script src="{{ asset('themes/sash') }}/assets/plugins/toastr/toastr.js"></script>
<script src="{{ asset('themes/sash') }}/assets/plugins/sidemenu/sidemenu.js"></script>
<script src="{{ asset('themes/sash') }}/assets/plugins/sidebar/sidebar.js"></script>
<script src="{{ asset('themes/sash') }}/assets/plugins/p-scroll/perfect-scrollbar.js"></script>
<script src="{{ asset('themes/sash') }}/assets/js/sticky.js"></script>
<script src="{{ asset('themes/sash') }}/assets/js/custom.js"></script>

<!-- Plugins -->
<script src="{{ asset('core/js/helper.js') }}?v={{ time() }}"></script>
<script src="{{ asset('core/js/additional.js') }}?v={{ time() }}"></script>
<script>
var BASE_URL = '{{ admin_url('/') }}';
var SITE_URL = '{{ url('/') }}';
var STORAGE_URL = '{{ Storage::url('/') }}';
var CSRF_TOKEN = '{{ csrf_token() }}';
var DEFAULT_LANGUAGE = '{{ Autocrud::defaultLang() }}';
</script>

@include ('themes::include.error-management')
@stack ('script')
@yield ('datatable_script')
@if(isset($custom_js))
<script type="text/javascript" src="{{ $custom_js }}"></script>
@endif