<script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
<script src="{{ admin_asset('js/app.js') }}"></script>


<!-- Plugins -->
<script src="{{ admin_asset('js/plugins.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ admin_asset('js/dropzone-input.js') }}"></script>
<script src="{{ admin_asset('js/helper.js') }}?v={{ time() }}"></script>
<script src="{{ admin_asset('js/additional.js') }}?v={{ time() }}"></script>
<script src="{{ admin_asset('js/media.js') }}"></script>
<script>
var BASE_URL = '{{ admin_url('/') }}';
var SITE_URL = '{{ url('/') }}';
var STORAGE_URL = '{{ Storage::url('/') }}';
var CSRF_TOKEN = '{{ csrf_token() }}';
var DEFAULT_LANGUAGE = '{{ Language::default() }}';
</script>
@include ('core::layouts.include.error-management')
@stack ('script')
@yield ('datatable_script')
@if(isset($custom_js))
<script type="text/javascript" src="{{ $custom_js }}"></script>
@endif