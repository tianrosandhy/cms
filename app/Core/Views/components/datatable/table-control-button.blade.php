<div class="btn-control pb-3">
	<a href="#" class="btn btn-light btn-rounded" data-toggle="modal" data-target="#searchBox-{{ $skeleton->name() }}"><i class="iconify" data-icon="ic:baseline-manage-search"></i> Advance Search</a>
	@if(method_exists($skeleton, 'batchDeleteRoute'))
		<?php
		$batch_delete_url = $skeleton->batchDeleteRoute();
		?>
		@if(isset($batch_delete_url))
		<div style="display:inline-block;">
			<a href="{{ $batch_delete_url }}" class="btn btn-danger btn-rounded multi-delete batchbox" style="display:none;">
				<i class="iconify" data-icon="ic:outline-delete-forever"></i> {{ __('core::module.form.delete_selected') }}
			</a>
		</div>
		@endif
	@endif
</div>