@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<link href="{{mix('plugins/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>


@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{mix('plugins/js/autoNumeric.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.validate.min.js')}}" type="text/javascript"></script>
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out90')
<script src="{{mix('js/client/employee/resignation.js')}}"></script>

@endpush

@section('content')

    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('employee.list')}}">Employee</a></li>
                        <li class="breadcrumb-item active">Resignation</li>
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
            <div id="vc-employee-resignation"></div>
        </div>

    </div>
    <!-- END PAGE CONTENT -->

@endsection