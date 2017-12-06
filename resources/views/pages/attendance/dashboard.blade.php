@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')

@endpush

@section('content')

    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('attendance')}}">Attendance</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg sm-gutter">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card no-border widget-loader-bar m-b-10 bg-transparent">
                        <div class="container-xs-height full-height">
                            <div class="row-xs-height">
                                <div class="col-xs-height col-top">
                                    <div class="p-l-20 p-t-20 p-b-20 p-r-20">
                                        <h3 class="no-margin">
                                            <span class="left-0"><i class="fa fa-circle text-complete fs-16"></i></span>
                                            {{\Carbon\Carbon::now()->toDayDateTimeString()}}
                                            <span class="help pull-right ">
                                                ( Week {{\Carbon\Carbon::now()->weekOfYear}})
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-flex flex-column">
                    <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                        <div class="card-header m-b-10">
                            <h5 class="text-primary pull-left fs-14 bold no-margin">
                                Who's In <i class="fa fa-circle text-complete fs-11"></i>
                            </h5>
                            <div class="clearfix"></div>
                        </div>
                        <div class="scrollable">
                            <div style="height: 740px">
                                <div class="container-fluid sm-p-l-5 bg-master-lighter ">
                                    <div class="timeline-container top-circle">
                                        <section class="timeline">
                                            <div class="timeline-block">
                                                <div class="timeline-point success">
                                                    <i class="pg-map"></i>
                                                </div>
                                                <!-- timeline-point -->
                                                <div class="timeline-content">
                                                    <div class="card social-card share full-width">
                                                        <div class="circle" data-toggle="tooltip" title="Label"
                                                             data-container="body">
                                                        </div>
                                                        <div class="card-header clearfix">
                                                            <div class="user-pic">
                                                                <img alt="Profile Image" width="33" height="33"
                                                                     data-src-retina="assets/img/profiles/8x.jpg"
                                                                     data-src="assets/img/profiles/8.jpg"
                                                                     src="assets/img/profiles/8x.jpg">
                                                            </div>
                                                            <h5>Jeff Curtis</h5>
                                                            <h6>Shared a Tweet
                                                                <span class="location semi-bold"><i
                                                                            class="fa fa-map-marker"></i> SF, California</span>
                                                            </h6>
                                                        </div>
                                                        <div class="card-description">
                                                            <p>What you think, you become. What you feel, you attract.
                                                                What you imagine, you create - Buddha. <a href="#">#quote</a>
                                                            </p>
                                                            <div class="via">via Twitter</div>
                                                        </div>
                                                    </div>
                                                    <div class="event-date">
                                                        <h6 class="font-montserrat all-caps hint-text m-t-0">Apple
                                                            Inc</h6>
                                                        <small class="fs-12 hint-text">15 January 2015, 06:50 PM</small>
                                                    </div>
                                                </div>
                                                <!-- timeline-content -->
                                            </div>
                                            <!-- timeline-block -->
                                            <div class="timeline-block">
                                                <div class="timeline-point small">
                                                </div>
                                                <!-- timeline-point -->
                                                <div class="timeline-content">
                                                    <div class="card  social-card share full-width">
                                                        <div class="circle" data-toggle="tooltip" title="Label"
                                                             data-container="body">
                                                        </div>
                                                        <div class="card-header clearfix">
                                                            <div class="user-pic">
                                                                <img alt="Profile Image" width="33" height="33"
                                                                     data-src-retina="assets/img/profiles/5x.jpg"
                                                                     data-src="assets/img/profiles/5.jpg"
                                                                     src="assets/img/profiles/5x.jpg">
                                                            </div>
                                                            <h5>Shannon Williams</h5>
                                                            <h6>Shared a photo
                                                                <span class="location semi-bold"><i
                                                                            class="fa fa-map-marker"></i> NYC, New York</span>
                                                            </h6>
                                                        </div>
                                                        <div class="card-description">
                                                            <p>Inspired by : good design is obvious, great design is
                                                                transparent</p>
                                                            <div class="via">via themeforest</div>
                                                        </div>
                                                        <div class="card-content">
                                                            <ul class="buttons ">
                                                                <li>
                                                                    <a href="#"><i class="fa fa-expand"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#"><i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <img alt="Social post"
                                                                 src="assets/img/social-post-image.png">
                                                        </div>
                                                        <div class="card-footer clearfix">
                                                            <div class="time">few seconds ago</div>
                                                            <ul class="reactions">
                                                                <li><a href="#">5,345 <i
                                                                                class="fa fa-comment-o"></i></a>
                                                                </li>
                                                                <li><a href="#">23K <i class="fa fa-heart-o"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="event-date">
                                                        <small class="fs-12 hint-text">15 January 2015, 06:50 PM</small>
                                                    </div>
                                                </div>
                                                <!-- timeline-content -->
                                            </div>
                                            <!-- timeline-block -->
                                            <div class="timeline-block">
                                                <div class="timeline-point warning">
                                                    <i class="pg-social"></i>
                                                </div>
                                                <!-- timeline-point -->
                                                <div class="timeline-content">
                                                    <div class="card social-card share full-width ">
                                                        <div class="card-header clearfix">
                                                            <h5 class="text-warning-dark pull-left fs-12">Stock Market
                                                                <i class="fa fa-circle text-warning-dark fs-11"></i>
                                                            </h5>
                                                            <div class="pull-right small hint-text">
                                                                5,345 <i class="fa fa-comment-o"></i>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="card-description">
                                                            <h5 class='hint-text no-margin'>Apple Inc.</h5>
                                                            <h5 class="small hint-text no-margin">NASDAQ: AAPL - Nov 13
                                                                8:37 AM ET</h5>
                                                            <h3>111.25 <span class="text-warning-dark"><i
                                                                            class="fa fa-sort-up small text-warning-dark"></i> 0.15 (0.13%)</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-footer clearfix">
                                                            <div class="pull-left">by <span class="text-warning-dark">John Smith</span>
                                                            </div>
                                                            <div class="pull-right hint-text">
                                                                Apr 23
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <div class="event-date">
                                                        <h6 class="font-montserrat all-caps hint-text m-t-0">Shared</h6>
                                                        <small class="fs-12 hint-text">15 January 2015, 06:50 PM</small>
                                                    </div>
                                                </div>
                                                <!-- timeline-content -->
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex flex-column">
                    <div class="row">
                        <div class="col-lg-12 m-b-10 d-flex">
                            <!-- START WIDGET widget_pendingComments.tpl-->
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-header m-b-10">
                                    <h5 class="text-primary pull-left fs-14 bold no-margin">Live Punch Clock Feed <i
                                                class="fa fa-circle text-complete fs-11"></i></h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="auto-overflow widget-11-2-table">
                                    @for($i=0;$i<10;$i++)
                                        <div class="d-flex-not-important flex-column filter-item">
                                            <div class="card social-card share  m-b-0 full-width d-flex flex-1 full-height no-border "
                                                 data-social="item">
                                                <div class="card-header clearfix">
                                                    <div class="user-pic">
                                                        <img alt="Avatar" width="33" height="33"
                                                             data-src-retina="{{asset('core/img/profiles/avatar_small2x.jpg')}}"
                                                             data-src="{{asset('core/img/profiles/avatar.jpg')}}"
                                                             src="{{asset('core/img/profiles/avatar_small2x.jpg')}}">
                                                    </div>
                                                    <h5>David Nester</h5>
                                                    <h6>Shared a link on your wall</h6>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor
                                </div>
                                <div class="padding-25 mt-auto">
                                    <p class="small no-margin">
                                        <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                                        <span class="hint-text ">Show more details of APPLE . INC</span>
                                    </p>
                                </div>
                            </div>
                            <!-- END WIDGET -->
                        </div>
                        <div class="col-lg-12 m-b-10">
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-header m-b-10">
                                    <h5 class="text-primary pull-left fs-14 bold no-margin">Head of Divisions </h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="auto-overflow h-273">
                                    <table class="table table-condensed table-hover">
                                        <tbody>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="padding-25 mt-auto">
                                    <p class="small no-margin">
                                        <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                                        <span class="hint-text ">Show more details of APPLE . INC</span>
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-4 d-flex flex-column">
                    <div class="row">
                        <div class="col-lg-12 m-b-10">
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-header m-b-10">
                                    <h5 class="text-primary pull-left fs-14 bold no-margin">Task List </h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="auto-overflow h-273">
                                    <table class="table table-condensed table-hover">
                                        <tbody>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="padding-25 mt-auto">
                                    <p class="small no-margin">
                                        <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                                        <span class="hint-text ">Show more details of APPLE . INC</span>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 m-b-10">
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-header m-b-10">
                                    <h5 class="text-primary pull-left fs-14 bold no-margin">Attendance Devices </h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="auto-overflow h-273">
                                    <table class="table table-condensed table-hover">
                                        <tbody>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-montserrat all-caps fs-12 w-50">Purchase CODE #2345</td>
                                            <td class="text-right hidden-lg">
                                                <span class="hint-text small">dewdrops</span>
                                            </td>
                                            <td class="text-right b-r b-dashed b-grey w-25">
                                                <span class="hint-text small">Qty 1</span>
                                            </td>
                                            <td class="w-25">
                                                <span class="font-montserrat fs-18">$27</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="padding-25 mt-auto">
                                    <p class="small no-margin">
                                        <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                                        <span class="hint-text ">Show more details of APPLE . INC</span>
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection