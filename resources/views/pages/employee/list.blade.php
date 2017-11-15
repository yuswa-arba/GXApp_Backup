@extends('layouts.main')

@push('child-styles')
@endpush

@push('child-scripts-plugins')
@endpush

@push('child-page-controller')
<script src="{{mix('js/client/employee/list.js')}}"></script>

@endpush

@section('content')

    <div class="content" >
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('employee')}}">Employee</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->

            <div id="vc-employee-list"></div>
            {{--<div class="row" id="vc-employee-list">--}}
                {{--@for($i=0;$i<15;$i++)--}}
                    {{--<div class="col-lg-3 col-sm-6  d-flex flex-column">--}}
                        {{--<!-- START ITEM -->--}}
                        {{--<div class="card social-card share  full-width m-b-10 d-flex flex-1 full-height no-border sm-vh-75"--}}
                             {{--data-social="item">--}}
                            {{--<div class="card-header clearfix">--}}
                                {{--<div class="user-pic">--}}
                                    {{--<img alt="Avatar" width="33" height="33"--}}
                                         {{--data-src-retina="{{asset('core/img/profiles/avatar_small2x.jpg')}}"--}}
                                         {{--data-src="{{asset('core/img/profiles/avatar.jpg')}}"--}}
                                         {{--src="{{asset('core/img/profiles/avatar_small2x.jpg')}}">--}}
                                {{--</div>--}}
                                {{--<h5>David Nester</h5>--}}
                                {{--<h6>Shared a link on your wall</h6>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- END ITEM -->--}}
                    {{--</div>--}}
                {{--@endfor--}}
            {{--</div>--}}

        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection