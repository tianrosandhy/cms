@stack ('style')
<div class="ajax-holder" data-title="{{ isset($title) ? $title : '' }}">
  @yield ('content')
</div>
@stack ('script')