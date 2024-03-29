<div class="media user-profile mt-2 mb-2">
    <?php
    $fallback_img = admin_asset('images/default-user.png');    
    $user_img = $user->getImageUrl('image', 'cropped');
    if(empty($user_img)){
        $user_img = $fallback_img;
    }
    ?>
    <img src="{{ $user_img }}" class="avatar-sm rounded-circle mr-2" alt="User Photo" />
    <img src="{{ $user_img }}" class="avatar-xs rounded-circle mr-2" alt="User Photo" />

    <div class="media-body">
        <h6 class="pro-user-name mt-0 mb-0">{{ $user->name ?? null }}</h6>
        <span class="pro-user-desc">{{ $role->name ?? null }}</span>
    </div>
    <div class="dropdown align-self-center profile-dropdown-menu">
        <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
            aria-expanded="false">
            <span class="iconify" data-icon="akar-icons:chevron-down"></span>
        </a>
        <div class="dropdown-menu profile-dropdown">
            <a href="{{ route('admin.my-profile') }}" class="dropdown-item notify-item">
                <span class="iconify icon-dual icon-xs mr-2" data-icon="uim:user-md"></span>
                <span>{{ __('core::module.global.my_profile') }}</span>
            </a>

            <div class="dropdown-divider"></div>

            <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
                <span class="iconify icon-dual icon-xs mr-2" data-icon="uim:exit"></span>
                <span>{{ __('core::module.global.logout') }}</span>
            </a>
        </div>
    </div>
</div>