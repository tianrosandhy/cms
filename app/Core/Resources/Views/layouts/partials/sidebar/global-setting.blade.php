@if(isset($setting))
<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="p-2 text-center">
            <h5>Web Setting</h5>
        </div>

        <form action="{{ route('admin.setting.store') }}" method="post" class="setting-form">
            {{ csrf_field() }}
            @foreach($setting as $group => $lists)
            <h6 class="px-4 py-3 bg-light">{{ ucwords($group) }} </h6>
            <div class="p-4">
                @foreach($lists['items'] as $item)
                    <div class="form-group">
                        <label class="font-weight-medium">{{ $item->getTitle() }}</label>
                        {!! TianRosandhy\Autocrud\Facades\Input::type($item->getType(), $group.'['.$item->getName().']', [
                            'attr' => $item->getConfig(),
                            'value' => $item->getValue()
                        ]) !!}
                    </div>
                @endforeach
            </div>
            @endforeach

            <div class="p-3">
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="iconify" data-icon="carbon:save"></span> {{ __('core::module.form.save_setting') }}
                </button>
            </div>
        </form>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

@endif