<script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
<script src="{{ asset('themes/'.config('cms.admin.themes', 'xoric').'/script.js') }}"></script>
{!! Autocrud::js() !!}

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

@include ('core::layouts.include.error-management')
@stack ('script')
@yield ('datatable_script')
@if(isset($custom_js))
<script type="text/javascript" src="{{ $custom_js }}"></script>
@endif