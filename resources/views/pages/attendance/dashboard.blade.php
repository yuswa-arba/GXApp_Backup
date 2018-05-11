@extends('layouts.main')
@push('child-styles')
<!-- push needed plugins for this page-->
@endpush
@push('child-scripts-plugins')
<!-- push needed plugins for this page -->

{{--<script src="{{asset('plugins/fullcalendar/js/moment.min.js')}}"></script>--}}
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._notification_to_zoom_out')

<script src="{{mix('js/client/attendance/dashboard.js')}}"></script>


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



        <div class="filter-container">

            <div id="vc-attendance-dashboard"></div>
        </div>

    </div>
    <!-- END PAGE CONTENT -->

@endsection