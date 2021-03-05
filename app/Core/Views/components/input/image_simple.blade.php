<?php
$base_class = ['form-control'];
if(isset($attr['class'])){
  $class = $attr['class'];
}
if(isset($class)){
  $base_class = array_merge($base_class, $class);
}

$cleaned_name = str_replace('[]', '', $name);
?>
<div class="image_simple">
  <div class="image-holder" style="position:relative; {!! empty($value) ? 'display:none' : 'display:inline-block' !!}">
    <div class="image-closer remove-image text-center"><i data-feather="x"></i></div>
    <img src="{{ $value ? storage_url($value) : null }}" alt="Image Preview" class="img-preview" style="max-height:120px;">
  </div>
  @if($value)
  <input type="hidden" name="{{ $cleaned_name }}_old" value="{{ encrypt($value) }}">
  @endif
  <input style="{!! empty($value) ? '' : 'display:none' !!}" accept="image/*" type="file" name="{{ $name }}" class="{!! implode(' ', $base_class) !!}" {!! isset($attr) ? array_to_html_prop($attr, ['class', 'type', 'name', 'id']) : null !!} id="input-{{ $cleaned_name }}">
</div>
