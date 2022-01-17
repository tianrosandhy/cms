@include ('core::components.datatable.table-control-button')
@include ('core::components.datatable.filter-box')
<table class="table datatable" data-structure="{{ $structure->name() }}">
	<thead>
		<tr>
			@foreach($structure->output() as $row)
				@if(!$row->getHideTable())
				<th data-field="{{ $row->getField() }}" data-orderable="{{ $row->getOrderable() }}"  id="datatable-{{ $structure->name() }}-{{ $row->getField() }}">{!! $row->getName() !!}</th>
				@endif
			@endforeach
			<th data-field="action" data-orderable="false" id="datatable-{{ $structure->name() }}-action"></th>
		</tr>
	</thead>
	<tbody></tbody>
</table>