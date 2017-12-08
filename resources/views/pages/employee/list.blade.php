@extends('layouts.main')

@push('child-styles')
@endpush

@push('child-scripts-plugins')
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._notification_to_zoom_out')
<script src="{{mix('js/client/employee/list.js')}}"></script>

@endpush

@section('content')

    <div class="content">
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

        <div class="container-fluid container-fixed-lg">
            <!-- Error Response -->
            <div id="errors-container" class="alert alert-danger hide" role="alert">
                <strong>Error: </strong> <span id="errors-value"></span>
            </div>
            <!-- End of Error Response -->
        </div>

        <div class="filter-container">
            <div id="vc-employee-list"></div>
        </div>


    </div>
    <!-- END PAGE CONTENT -->

@endsection