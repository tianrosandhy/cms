<li class="dd-item dd3-item" data-id="{{ $list['id'] }}">
	<div class="dd-handle dd3-handle"></div>
	<div class="dd3-content">
		<a class="btn-update-menu btn-as-link" data-navigation-item-id="{{ $list['id'] }}" href="#">{{ $list['label'] }} (#{{ $label }})</a>
		<div class="navigation-buttons">
			@if(Permission::has('admin.navigation_item.edit'))
	    	<a href="#" class="btn btn-sm btn-info btn-update-menu" data-navigation-item-id="{{ $list['id'] }}" title="Edit">
	    		<i class="fa fa-pencil"></i>
	    		Edit
	    	</a>
	    	@endif
	    	@if(Permission::has('admin.navigation_item.delete'))
	    	<a href="{{ route('admin.navigation_item.delete', ['id' => $list['id']]) }}" class="btn btn-sm btn-danger delete-button" data-callback="afterDeleteNavigation" title="Delete">
	    		<i class="fa fa-trash"></i>
	    		Delete
	    	</a>
	    	@endif
		</div>
	</div>
	@if(isset($list['submenu']))
		<?php
		$current_level++;
		?>
		@if($current_level <= $max_level)
			<ol class="dd-list">
			@foreach($list['submenu'] as $sublabel => $sublist)
				@include ('navigation::partials.nav-handle', [
					'label' => $sublabel,
					'list' => $sublist,
					'max_level' => $max_level,
					'current_level' => $current_level,
				])
			@endforeach
			</ol>
		@endif
	@endif
</li>