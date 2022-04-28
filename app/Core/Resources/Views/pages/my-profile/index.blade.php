@extends ('themes::master')
@section ('content')

<div class="card">
	<div class="card-body">

		<form action="" method="post">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label>Name</label>
						<x-autocrud-input::text name="name" :attr="[
								'required' => 'required',
								'placeholder' => 'Type Your Name',
								'maxlength' => 50
						]" :value="$user->name" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<x-autocrud-input::email name="email" :value="$user->email" :attr="[
								'maxlength' => 75,
								'required' => 'required'
						]" />
					</div>

					<div class="change-pass">
						<button type="button" class="btn btn-sm btn-danger btn-change-pass">Change Password</button>
					</div>
					<div class="pass-toggle" style="display:none; padding:1em 0;">
						<div class="row">
							<div class="col-6">
								<div class="form-group custom-form-group searchable">
									<label>Password</label>
									<x-autocrud-input::password name="password" :attr="[
										'data-password' => 'true',
										'placeholder' => 'Keep blank if you dont want to change',
										'autocomplete' => 'off'
									]" />
								</div>
							</div>
							<div class="col-6">
								<div class="form-group custom-form-group searchable">
									<label>Repeat Password</label>
									<x-autocrud-input::password name="password_confirmation" :attr="[
										'data-password' => 'true',
										'autocomplete' => 'off'
									]" />
								</div>
							</div>
						</div>
					</div>

					<div class="my-3">
						<button type="submit" class="btn btn-primary">
							<span class="iconify" data-icon="carbon:save"></span> Save Profile
						</button>
					</div>


				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Profile Photo</label>
						<x-autocrud-input::image name="image" :value="$user->image" />
					</div>
				</div>
			</div>
		</form>

	</div>
</div>
@stop

@push ('script')
<script>
$(function(){
	$(".btn-change-pass").on('click', function(){
		$(".pass-toggle").slideDown();
		$(".btn-change-pass").slideUp();

		$("input[data-password]").attr('type', 'password');
	});
});
</script>
@endpush