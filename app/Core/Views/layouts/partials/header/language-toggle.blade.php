<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-flag-dropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="" src="{{ admin_asset('images/flag/'.strtoupper(Language::current()).'.png') }}" alt="Current Language" height="14">
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach(Language::available() as $lang_code => $lang_title)
        <!-- item-->
        <a href="javascript:void(0);" class="dropdown-item notify-item">
            <img src="{{ admin_asset('images/flag/'.strtoupper($lang_code).'.png') }}" alt="user-image" class="mr-2" height="12"><span class="align-middle">{{ $lang_title }}</span>
        </a>
        @endforeach
    </div>
</div>