@extends ('themes::master')

@section ('content')

	@if(Permission::has('admin.log.export'))
	<form action="" class="card card-body">
		<div class="alert alert-info">You can export this site log data by select the file below.</div>
		<div class="form-group custom-form-group">
			<label>Choose Log Filename</label>
			<select name="active_log" class="form-control select2" onchange="this.form.submit()">
				<option value="">- Choose Log Filename -</option>
				@foreach($available_log as $logs)
				<option value="{{ $logs }}" {{ $logs == $active_log ? 'selected' : '' }}>{{ $logs }}</option>
				@endforeach
			</select>
		</div>

		@if($active_log)
		<div class="panel">
			<div style="padding:1em 0">
				@if(isset($log_size))
				<strong>Log File Size : {{ $log_size }}</strong>
				@endif
				<a href="{{ url()->route('admin.log.export') }}?active_log={{ $active_log }}" class="btn btn-primary btn-block">Export Log</a>
			</div>
		</div>
		@endif
	</form>
	@else
	<div class="alert alert-warning">You doesn't have permission to export the stored log file</div>
	@endif

@stop
