<div class="dropdown d-inline-block">
    <?php
    $user_thumb_img_src = admin_asset('images/default-user.png');
    if($user->image){
        $user_thumb_img_src = $user->getImageUrl('image', 'thumb');
    }
    ?>
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="{{ $user_thumb_img_src }}" alt="Current User Image">
        <span class="d-none d-sm-inline-block ml-1">{{ $user->name ?? '-' }}</span>
        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ config('app.url') }}" class="dropdown-item notify-item">
            <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i>
            <span>{{ __('core::module.global.go_to_site') }}</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.my-profile') }}" class="dropdown-item notify-item">
            <i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i>
            <span>{{ __('core::module.global.my_profile') }}</span>
        </a>
        <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
            <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i>
            <span>{{ __('core::module.global.logout') }}</span>
        </a>
    </div>
</div>