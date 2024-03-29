<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-1">{{ $title ?? '' }}</h4>
                @include ('core::components.breadcrumb')
            </div>
            <div class="col-md-6 text-right text-end">
                <!-- Control buttons here -->

                <div class="btn-groups btn-rounded">
                    @yield ('control_buttons')
                    @if(isset($control_buttons))
                        @foreach($control_buttons as $btn)
                            @if(isset($btn['label']))
                            <a href="{{ $btn['url'] ?? '#' }}" class="btn btn-rounded btn-{{ $btn['type'] ?? 'light' }} page-navigate" {!! isset($btn['attr']) ? array_to_html_prop($btn['attr']) : '' !!}>
                                @if(isset($btn['icon']))
                                <span class="iconify" data-icon="{{ $btn['icon'] }}"></span>
                                @endif
                                <span>{{ $btn['label'] ?? '-' }}</span>
                            </a>
                            @endif
                        @endforeach
                    @endif

                </div>
            
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->
