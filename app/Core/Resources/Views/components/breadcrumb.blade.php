@if(isset($breadcrumb) && !isset($hide_breadcrumb))
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ admin_url('/') }}">{{ __('core::module.menu.home') }}</a></li>
	@foreach($breadcrumb as $items)
		@if(isset($items['label']))
	    <li class="breadcrumb-item"><a href="{{ url( $items['url'] ?? '/' ) }}">{{ $items['label'] }}</a></li>
	    @endif
    @endforeach
    @if(isset($title))
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    @endif
</ol>
@endif