<!-- LOGO -->
<div class="navbar-brand-box">
    <?php
    $generalLogo = setting('general.logo');
    if(!$generalLogo){
        $generalLogo = admin_asset('images/logo.png');
    }
    ?>
    <a href="{{ admin_url('/') }}" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ $generalLogo }}" alt="Logo Dark SM" height="22">
        </span>
        <span class="logo-lg">
            <img src="{{ $generalLogo }}" alt="Logo Dark LG" height="20">
        </span>
    </a>

    <a href="{{ admin_url('/') }}" class="logo logo-light">
        <span class="logo-sm">
            <img src="{{ $generalLogo }}" alt="Logo Light SM" height="22">
        </span>
        <span class="logo-lg">
            <img src="{{ $generalLogo }}" alt="Logo Light LG" height="20">
        </span>
    </a>
</div>
