
<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-1">{{ $title ?? '' }}</h4>
				@include ('core::components.breadcrumb')
            </div>
            <div class="col-md-6">
				<!-- Control buttons here -->

				<div class="btn-group btn-rounded">
					@if(isset($control_buttons))
						@foreach($control_buttons as $btn)
							@if(isset($btn['label']))
							<a href="{{ $btn['url'] ?? '#' }}" class="btn btn-rounded btn-{{ $btn['type'] ?? 'light' }} page-navigate" {!! isset($btn['attr']) ? array_to_html_prop($btn['attr']) : '' !!}>
								@if(isset($btn['icon']))
								<i class="icon" data-feather="{{ $btn['icon'] }}"></i>
								@endif
								<span>{{ $btn['label'] ?? '-' }}</span>
							</a>
							@endif
						@endforeach
					@endif
				</div>
				@if(isset($batch_delete_url))
				<div style="display:inline-block;">
					<a href="{{ $batch_delete_url }}" class="btn btn-danger btn-rounded multi-delete batchbox" style="display:none;">
						<i data-feather="x"></i> {{ __('core::module.form.delete_selected') }}
					</a>
				</div>
				@endif						
			
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->