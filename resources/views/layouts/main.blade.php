<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8"/>
    <title>GXApp Employee Helpdesk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    {{--<link rel="apple-touch-icon" href="pages/ico/60.png">--}}
    {{--<link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">--}}
    {{--<link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">--}}
    {{--<link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">--}}
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    @include('layouts.partials._header')

</head>
<body class="fixed-header menu-pin menu-behind">

@include('layouts.partials._sidebar')

<!-- START PAGE-CONTAINER -->
<div class="page-container">
@include('layouts.partials._navigation')
<!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->

        @yield('content')

        @include('layouts.partials._footer_in_page')
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->
@include('layouts.partials._quickview')
@include('layouts.partials._overlay')

@include('layouts.partials._footer')

</body>
</html>