<div class="card card-body collapse" id="searchBox-{{ $skeleton->name() }}">
	<!-- for datatable components -->
	<div class="search-box my-2">
		<div class="row">
			@foreach($skeleton->output() as $row)
				@if($row->getSearchable() && !$row->getHideTable())
				<div class="col-lg-4 col-md-6">
					<div class="form-group">
						<label>Filter {{ $row->getName() }}</label>
						<?php
						$rfield = str_replace('[]', '', $row->getField());
						?>
						@if($row->getDataSource() == 'text')
							{!! Input::text('datatable_filter['.$rfield.']', [
								'attr' => [
									'id' => 'datatable-filter-' . $rfield
								]
							]) !!}
						@else
							@if(is_array($row->getDataSource()))
							{!! Input::select('datatable_filter['.$rfield.']', [
								'source' => $row->getDataSource(),
								'attr' => [
									'id' => 'datatable-filter-' . $rfield
								]
							]) !!}
							@endif
						@endif
					</div>
				</div>
				@endif
			@endforeach
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label style="visibility:hidden">.</label>
					<div>
					<a href="#" class="btn btn-block btn-danger reset-filter" style="display:none;">
						<i data-feather="x"></i>
						Reset Filter
					</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="card card-body">
	<table class="table datatable" data-skeleton="{{ $skeleton->name() }}">
		<thead>
			<tr>
				@foreach($skeleton->output() as $row)
					@if(!$row->getHideTable())
					<th data-field="{{ $row->getField() }}" data-orderable="{{ $row->getOrderable() }}"  id="datatable-{{ $skeleton->name() }}-{{ $row->getField() }}">{!! $row->getName() !!}</th>
					@endif
				@endforeach
				<th data-field="action" data-orderable="false" id="datatable-{{ $skeleton->name() }}-action"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>