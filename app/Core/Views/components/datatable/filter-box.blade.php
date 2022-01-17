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
									@include ('core::components.filter-dynamic-input.index')
								</div>
							</div>
							@endif
						@endforeach
					</div>
				</div>

				<button type="button" class="btn btn-rounded btn-secondary btn-apply-filter"><i class="iconify" data-icon="ic:outline-filter-alt"></i> {{ __('core::module.form.apply_filter') }}</button>

				<a href="#" class="btn btn-rounded btn-danger reset-filter">
					<i class="iconify" data-icon="ic:outline-filter-alt"></i>
					{{ __('core::module.form.reset_filter') }}
				</a>

			</div>
		</div>
	</div>
</div>
