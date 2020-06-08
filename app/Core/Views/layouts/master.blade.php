<!DOCTYPE html>
<html lang="en">
<head>
	@include ('core::layouts.partials.metadata')
</head>
<body class="left-side-menu-dark">
    <div id="wrapper">
		@include ('core::layouts.partials.header')
		@include ('core::layouts.partials.sidebar')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid mt-3">
                	@yield ('content')
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            @include ('core::layouts.partials.footer')
        </div>
    </div>

    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="m-0">Setting</h5>
        </div>

        <div class="slimscroll-menu">
        	<div class="alert alert-info">Setting page will be loaded via ajax</div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
	@include ('core::layouts.partials.script')
</body>
</html>