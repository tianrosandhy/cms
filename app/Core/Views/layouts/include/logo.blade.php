@if(isset($target))
<a href="{{ $target }}">
@endif
	<img src="{{ admin_asset('images/logo.png') }}" alt="{{ isset($image_title) ? $image_title : 'Logo' }}" style="
		@if(isset($width))
		width:{{ $width }}px;
		@endif
		@if(isset($height))
		height:{{ $height }}px;
		@endif
	">
@if(isset($target))
</a>
@endif