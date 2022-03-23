<div class="btn-control pb-3">
    <div class="btn-control-inner" style="display:inline-block">
        <button type="button" class="btn btn-light btn-rounded" data-bs-toggle="modal" data-bs-target="#searchBox-{{ $hash }}"><i class="iconify" data-icon="ic:baseline-manage-search"></i> Filter Data</button>
    </div>

	@if(method_exists($context, 'batchDeleteRoute'))
		<?php
		$batch_delete_url = $context->batchDeleteRoute();
		?>
		@if(isset($batch_delete_url))
		<div class="btn-control-inner" style="display:inline-block;">
			<a href="{{ $batch_delete_url }}" class="btn btn-danger btn-rounded multi-delete batchbox" style="display:none;">
				<i class="iconify" data-icon="ic:outline-delete-forever"></i> Remove Selected
			</a>
		</div>
		@endif
	@endif
</div>