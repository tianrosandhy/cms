<!-- Sidebar-right -->
<div class="sidebar sidebar-right sidebar-animate">
    <div class="panel panel-primary card mb-0 shadow-none border-0">
        <div class="tab-menu-heading border-0 d-flex p-3">
            <div class="card-title mb-0"><i class="fe fe-bell me-2"></i>Web Setting</div>
            <div class="card-options ms-auto">
                <a href="javascript:void(0);" class="sidebar-icon text-end float-end me-3 mb-1" data-bs-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x text-white"></i></a>
            </div>
        </div>
        <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
            <form action="{{ route('admin.setting.store') }}" method="post" class="setting-form">
                {{ csrf_field() }}
                @foreach($setting as $group => $lists)
                <h6 class="px-4 py-3 bg-light font-weight-bold">{{ strtoupper($group) }} </h6>
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
        </div>
    </div>
</div>
<!--/Sidebar-right-->