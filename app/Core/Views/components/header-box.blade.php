
<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-1">{{ $title ?? '' }}</h4>
				@include ('core::components.breadcrumb')
            </div>
            <div class="col-md-6 text-right">
				<!-- Control buttons here -->

				<div class="btn-groups btn-rounded">
					@if(isset($control_buttons))
						@foreach($control_buttons as $btn)
							@if(isset($btn['label']))
							<a href="{{ $btn['url'] ?? '#' }}" class="btn btn-rounded btn-{{ $btn['type'] ?? 'light' }} page-navigate" {!! isset($btn['attr']) ? array_to_html_prop($btn['attr']) : '' !!}>
								@if(isset($btn['icon']))
								<span class="iconify" data-icon="{{ $btn['icon'] }}"></span>
								@endif
								<span>{{ $btn['label'] ?? '-' }}</span>
							</a>
							@endif
						@endforeach
					@endif

					@if(isset($structure))
						@if(method_exists($structure, 'exportRoute'))
							<a href="{{ $structure->exportRoute() }}" class="btn btn-rounded btn-info" data-toggle="modal" data-target=".modal-exporter">
								<span class="iconify" data-icon="carbon:document-export"></span> {{ __('core::module.form.export_to_excel') }}
							</a>
						@endif
						@if(method_exists($structure, 'importRoute'))
							<a href="{{ $structure->importRoute() }}" class="btn btn-rounded btn-light" data-toggle="modal" data-target=".modal-importer">
								<span class="iconify" data-icon="carbon:document-import"></span> {{ __('core::module.form.import_from_excel') }}
							</a>
						@endif
						
					@endif
				</div>
			
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

@if(isset($structure))
	@if(method_exists($structure, 'exportRoute'))
		@include ('core::components.export-import.modal-exporter')	
	@endif
	@if(method_exists($structure, 'importRoute'))
		@include ('core::components.export-import.modal-importer')	
	@endif
@endif