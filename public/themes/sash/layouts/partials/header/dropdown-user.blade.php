<!-- SIDE-MENU -->
<?php
$user_thumb_img_src = admin_asset('images/default-user.png');
if($user->image){
    $user_thumb_img_src = $user->getImageUrl('image', 'thumb');
}
?>
<div class="dropdown d-flex profile-1">
    <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
        <img src="{{ $user_thumb_img_src }}" alt="profile-user" class="avatar  profile-user brround cover-image">
    </a>

    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <div class="drop-heading">
            <div class="text-center">
                <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ $user->name ?? '-' }}</h5>
            </div>
        </div>
        <div class="dropdown-divider m-0"></div>

        <a href="{{ config('app.url') }}" class="dropdown-item notify-item">
            <span class="iconify dropdown-icon align-middle mr-1" data-icon="mdi:web"></span>
            <span>{{ __('core::module.global.go_to_site') }}</span>
        </a>
        <a href="{{ route('admin.clear-cache') }}" class="dropdown-item notify-item">
            <span class="iconify dropdown-icon align-middle mr-1" data-icon="ic:sharp-cached"></span>
            <span>{{ __('core::module.global.clear_cache') }}</span>
        </a>

        <a href="{{ route('admin.my-profile') }}" class="dropdown-item notify-item">
            <span class="iconify dropdown-icon align-middle mr-1" data-icon="uim:user-md"></span>
            <span>{{ __('core::module.global.my_profile') }}</span>
        </a>
        <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
            <span class="iconify dropdown-icon align-middle mr-1" data-icon="majesticons:door-exit"></span>
            <span>{{ __('core::module.global.logout') }}</span>
        </a>

    </div>
</div>