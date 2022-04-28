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
<a class="logo-horizontal " href="{{ admin_url('/') }}">
    <img src="{{ $generalLogo }}" class="header-brand-img desktop-logo" alt="logo" style="height:25px;">
    <img src="{{ $wideLogo }}" class="header-brand-img light-logo1" alt="logo" style="height:25px;">
</a>
