<!-- Left Menu Start -->
<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title">Menu</li>

    @foreach($sidebar as $key => $sidedata)
        @if($sidedata->getRoute())
            @if(!Permission::has($sidedata->getRoute()))
                @continue
            @endif
        @endif
        <li class="{{ in_array($selected_menu, $sidedata->getActiveKey()) ? 'mm-active' : '' }}">
            <a href="{{ $sidedata->getChildren() ? '#' : $sidedata->url() }}" class="{{ $sidedata->getChildren() ? 'has-arrow' : '' }} waves-effect">
                @if($sidedata->getIcon())
                <div class="d-inline-block icons-sm mr-1"><i class="iconify" data-icon="{{ $sidedata->getIcon() }}"></i></div>
                @endif
                <span> {{ $sidedata->getLabel() }} </span>
            </a>
            @if($sidedata->getChildren())
            <ul class="sub-menu" aria-expanded="false">
                @foreach($sidedata->getChildren() as $subkey => $subdata)
                    @if($subdata->getRoute())
                        @if(!Permission::has($subdata->getRoute()))
                            @continue
                        @endif
                    @endif
                    <li class="{{ in_array($selected_menu, $subdata->getActiveKey()) ? 'mm-active' : '' }}">
                        <a href="{{ $subdata->getChildren() ? '#' : $subdata->url() }}" class="{{ $subdata->getChildren() ? 'has-arrow' : '' }} waves-effect">
                            @if($subdata->getIcon())
                            <i class="iconify" data-icon="{{ $subdata->getIcon() }}"></i>
                            @endif
                            <span>{{ $subdata->getLabel() }}</span>
                        </a>
                        @if($subdata->getChildren())
                        <ul class="sub-menu" aria-expanded="false">
                            @if($subdata->getChildren())
                            @foreach($subdata->getChildren() as $thirdkey => $thirddata)
                                @if($thirddata->getRoute())
                                    @if(!Permission::has($thirddata->getRoute()))
                                        @continue
                                    @endif
                                @endif
                                <li class="{{ in_array($selected_menu, $thirddata->getActiveKey()) ? 'mm-active' : '' }}">
                                    <a href="{{ $thirddata->url() }}" class="waves-effect">
                                        @if($thirddata->getIcon())
                                        <i class="iconify" data-icon="{{ $thirddata->getIcon() }}"></i>
                                        @endif
                                        <span>{{ $thirddata->getLabel() }}</span>
                                    </a>
                                </li>
                            @endforeach
                            @endif
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
        </li>
    @endforeach

</ul>
