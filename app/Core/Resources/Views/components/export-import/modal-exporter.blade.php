<div class="modal fade modal-exporter" id="exportBox-{{ $structure->name() }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6>Export to Excel Filter</h6>
				<button data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body modal-searchbox">
				<!-- for datatable components -->
				<form action="{{ $structure->exportRoute() }}" class="search-box my-2">
                    @foreach($structure->output() as $row)
                        @if($row->getExportable() && $row->getExportSearchable() && !$row->getHideExport())
                            <div class="form-group">
                                <label>Filter {{ $row->getName() }}</label>
                                @include ('core::components.filter-dynamic-input.index')
                            </div>
                        @endif
                    @endforeach

                    <button type="submit" class="btn btn-rounded btn-secondary"><i class="iconify" data-icon="carbon:document-export"></i> Start Export</button>

                    <a href="#" class="btn btn-rounded btn-danger" data-dismiss="modal">
                        <i class="iconify" data-icon="ic:outline-filter-alt"></i>
                        Cancel Export
                    </a>
				</form>
			</div>
		</div>
	</div>
</div>
