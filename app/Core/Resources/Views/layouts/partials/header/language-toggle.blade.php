<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-flag-dropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="" src="{{ admin_asset('images/flag/'.strtoupper(Autocrud::currentLang()).'.png') }}" alt="Current Language" height="14">
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach(Autocrud::langs() as $lang_code => $lang_title)
        <!-- item-->
        <a href="{{ route('admin.lang.switch', ['lang' => $lang_code]) }}" class="dropdown-item notify-item">
            <img src="{{ admin_asset('images/flag/'.strtoupper($lang_code).'.png') }}" alt="user-image" class="mr-2" height="12"><span class="align-middle">{{ $lang_title }}</span>
        </a>
        @endforeach
    </div>
</div>