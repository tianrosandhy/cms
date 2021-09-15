<div class="modal fade modal-pagefilter" id="searchBox-{{ $structure->name() }}">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6>Data Filter</h6>
				<button data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body modal-searchbox">

				<!-- for datatable components -->
				<div class="search-box my-2">
					<div class="row">
						@foreach($structure->output() as $row)
							@if($row->getSearchable() && !$row->getHideTable())
							<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label>Filter {{ $row->getName() }}</label>
									<?php
									$rfield = str_replace('[]', '', $row->getField());
									?>
									@if($row->getDataSource() == 'text')
										@if(in_array($row->getInputType(), ['date', 'daterange', 'datetime']))
											{!! Input::dateRange('datatable_filter['.$rfield.'][]', [
												'attr' => [
													'data-id' => 'datatable-filter-' . $rfield
												]
											]) !!}
										@else
											{!! Input::text('datatable_filter['.$rfield.']', [
												'attr' => [
													'data-id' => 'datatable-filter-' . $rfield
												]
											]) !!}
										@endif
									@else
										<?php
										$source = $row->getDataSource();
										if(is_callable($source)){
											$source = call_user_func($source);
											if($source instanceof \Illuminate\Support\Collection){
												$source = collect()->unwrap($source);
											}
										}
										?>
										@if(is_array($source))
										{!! Input::select('datatable_filter['.$rfield.']', [
											'source' => $source,
											'attr' => [
												'data-id' => 'datatable-filter-' . $rfield
											]
										]) !!}
										@endif
									@endif
								</div>
							</div>
							@endif
						@endforeach
					</div>
				</div>

				<button type="button" class="btn btn-rounded btn-secondary btn-apply-filter"><i class="iconify" data-icon="ic:outline-filter-alt"></i> Apply Filter</button>

				<a href="#" class="btn btn-rounded btn-danger reset-filter">
					<i class="iconify" data-icon="ic:outline-filter-alt"></i>
					Reset Filter
				</a>

			</div>
		</div>
	</div>
</div>
