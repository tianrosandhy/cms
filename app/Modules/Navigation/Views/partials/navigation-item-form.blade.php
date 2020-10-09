<form action="" method="post">
	{{ csrf_field() }}
	<input type="hidden" name="group_id" value="{{ $data->id }}">
	@if(isset($navigation))
	<input type="hidden" name="navigation_item_id" value="{{ $navigation->id }}">
	@endif

	<div class="form-group custom-form-group">
		<label>Menu Action Type</label>
		<?php
		$sel = isset($navigation->type) ? $navigation->type : null;
		?>
		<select name="type" class="form-control select2 action-toggle">
			@foreach(config('module-setting.navigation.action_type') as $name => $param)
			<option data-target="{{ $name }}" data-url-prefix="{{ $param['url'] }}" data-fillable="{{ $param['fillable'] }}" value="{{ $name }}" {{ $sel == $name ? 'selected' : '' }}>{{ $param['label'] }}</option>
			@endforeach
		</select>
	</div>

	@foreach(config('module-setting.navigation.action_type') as $name => $param)
		@if($param['fillable'])
		<?php
		$sel_url = isset($navigation->url) ? $navigation->url : null;
		$sel_slug = isset($navigation->slug) ? $navigation->slug : null;
		?>
		<div class="form-group custom-form-group action-type-value" data-type="{{ $name }}" style="display:none;">
			<label>URL Target</label>
			@if(strlen($param['url']) > 0)
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						{{ $param['url'] == '#' ? '#' : $param['url'] }}
					</span>
				</div>
				@if(isset($param['model_source']))
				<?php
				$source = app($param['model_source']);
				if($param['source_is_active_field']){
					$source_data = $source->where($param['source_is_active_field'], 1)->get();
				}
				else{
					$source_data = $source->get();
				}
				?>
				<div class="select2-dynamic-container" style="flex:1 1 auto;">
					<select name="slug[{{ $name }}]" class="form-control select2">
						<option value=""></option>
						@foreach($source_data as $row)
						<option current_value="{{ $sel_slug }}" value="{{ $row->getCurrentSlug() }}" {{ $row->getCurrentSlug() == $sel_slug ? 'selected' : '' }}>{{ $row->{$param['source_label']} }}</option>
						@endforeach
					</select>
				</div>
				@endif
			</div>
			@elseif(isset($param['route_prefix']))
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">{{ urL('/') }}</span>
				</div>
				<div class="select2-dynamic-container" style="flex:1 1 auto;">
					<?php
					$prefix = 'front';
					$all_routes = collect(\Route::getRoutes()->getRoutesByName());
					$used_routes = [];
					foreach($all_routes as $keyr => $valr){
						if(strpos($keyr, $prefix) === 0){
							$methods = $valr->methods();
							if(!in_array('GET', $methods)){
								continue;
							}
							if(strpos($valr->uri(), '{') !== false && strpos($valr->uri(), '}') !== false){
								if(strpos($valr->uri(), '?}') === false){
									continue;
								}
							}

							$used_routes[] = $valr;
						}
					}
					?>
					<select name="slug[{{ $name }}]" class="form-control select2">
						<option value=""></option>
						@foreach($used_routes as $routes)
							<?php
							$ruri = $routes->uri();
							$ruri = preg_replace('/\/{[a-zA-Z?]+}/', '', $ruri);
							?>
							<option value="{{ $ruri }}" {{ $ruri == $sel_url ? 'selected' : '' }}>{{ $ruri }}</option>
						@endforeach
					</select>
				</div>

			</div>
			@else
			<input type="text" name="url" value="{{ $sel_url }}" class="form-control" placeholder="https://anything">
			@endif
		</div>
		@endif
	@endforeach

	@if(!Language::isActive())
	<div class="form-group custom-form-group">
		<label>Menu Label</label>
		<input type="text" class="form-control" name="title" maxlength="50" value="{{ isset($navigation->title) ? $navigation->title : '' }}">
	</div>
	@else
		@foreach(Language::available() as $lang => $langdata)
		<div class="form-group custom-form-group">
			<label>Menu Label ({{ strtoupper($lang) }})</label>
			<input type="text" class="form-control" name="title[{{ $lang }}]" maxlength="50" value="{{ isset($navigation->title) ? $navigation->outputTranslate('title', $lang) : '' }}">
		</div>
		@endforeach
	@endif

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group custom-form-group">
				<label>Open in New Tab</label>
				<?php
				$sel = isset($navigation->new_tab) ? (bool)$navigation->new_tab : false;
				?>
				<select name="new_tab" class="form-control">
					<option value="0" {{ $sel ? '' : 'selected' }}>No</option>
					<option value="1" {{ $sel ? 'selected' : '' }}>Yes</option>
				</select>
			</div>
		</div>
		<div class="col-sm-6">
			@if($data->max_level > 0)
			@if(!isset($navigation->id))
			<div class="form-group custom-form-group">
				<label>Set Menu Parent</label>
				<?php
				$struct = NavigationInstance::setData($data->id)->generateStructure($data->max_level-1);
				?>
				<select name="parent" class="form-control">
					<option value="">No Parent</option>
					@foreach($struct as $label => $param)
						@include ('navigation::partials.select-menu-item', [
							'label' => $param['label'],
							'param' => $param,
							'level' => 0,
							'selected' => isset($navigation->parent) ? $navigation->parent : null
						])
					@endforeach							
				</select>
			</div>
			@endif
			@endif

		</div>
	</div>


	<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Menu Data</button>

</form>