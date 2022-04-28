<?php
$selected_menu = $selected_menu ?? null;
?>
<!-- Left Menu Start -->
<ul class="side-menu" id="side-menu">
    <li class="sub-category">Menu</li>

    @foreach($sidebar as $key => $sidedata)
        @if($sidedata->getRoute())
            @if(!Permission::has($sidedata->getRoute()))
                @continue
            @endif
        @endif
        <li class="slide {{ in_array($selected_menu, $sidedata->getActiveKey()) ? 'mm-active' : '' }}">
            <a href="{{ $sidedata->getChildren() ? '#' : $sidedata->url() }}" class="side-menu__item" {!! $sidedata->getChildren() ? 'data-bs-toggle="slide"' : '' !!}>
                @if($sidedata->getIcon())
                <i class="side-menu__icon iconify" data-icon="{{ $sidedata->getIcon() }}"></i>
                @endif
                <span class="side-menu__label"> {{ $sidedata->getLabel() }} </span>
                @if ($sidedata->getChildren())
                <i class="angle iconify float-right" data-icon="fa-chevron-right"></i>
                @endif
            </a>
            @if($sidedata->getChildren())
            <ul class="sub-menu slide-menu" aria-expanded="false">
                @foreach($sidedata->getChildren() as $subkey => $subdata)
                    @if($subdata->getRoute())
                        @if(!Permission::has($subdata->getRoute()))
                            @continue
                        @endif
                    @endif
                    <li class="{{ $subdata->getChildren() ? 'sub-slide' : '' }} {{ in_array($selected_menu, $subdata->getActiveKey()) ? 'mm-active' : '' }}">
                        <a href="{{ $subdata->getChildren() ? '#' : $subdata->url() }}" class="{{ $subdata->getChildren() ? 'sub-side-menu__item' : 'slide-item' }} {{ $subdata->getChildren() ? 'has-arrow' : '' }}" {!! $subdata->getChildren() ? 'data-bs-toggle="sub-slide"' : '' !!}>
                            @if ($subdata->getChildren())
                            <span class="sub-side-menu__label"></span> <i class="sub-angle fe fe-chevron-right"></i>
                            @else
                            <span>{{ $subdata->getLabel() }}</span>
                            @endif
                        </a>
                        @if($subdata->getChildren())
                        <ul class="sub-slide-menu sub-menu" aria-expanded="false">
                            @if($subdata->getChildren())
                            @foreach($subdata->getChildren() as $thirdkey => $thirddata)
                                @if($thirddata->getRoute())
                                    @if(!Permission::has($thirddata->getRoute()))
                                        @continue
                                    @endif
                                @endif
                                <li class="{{ in_array($selected_menu, $thirddata->getActiveKey()) ? 'mm-active' : '' }}">
                                    <a href="{{ $thirddata->url() }}" class="sub-slide-item">
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
