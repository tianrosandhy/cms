<div class="side-header">
    <?php
    $generalLogo = setting('general.logo');
    if(!$generalLogo){
        $generalLogo = admin_asset('images/logo.png');
    }
    
    $wideLogo = setting('general.logo_wide');
    if(!$wideLogo){
        $wideLogo = admin_asset('images/wide_logo.png');
    }
    ?>
    <a class="header-brand1" href="index.html">
        <img src="{{ $generalLogo }}" class="header-brand-img desktop-logo" alt="logo">
        <img src="{{ $wideLogo }}" class="header-brand-img toggle-logo" alt="logo">
        <img src="{{ $generalLogo }}" class="header-brand-img light-logo" alt="logo">
        <img src="{{ $wideLogo }}" class="header-brand-img light-logo1" alt="logo">
    </a>
    <!-- LOGO -->
</div>