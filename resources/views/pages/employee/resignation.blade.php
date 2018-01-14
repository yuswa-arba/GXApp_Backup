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
@include('layouts.partials.snippets._notification_to_zoom_out')
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
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div id="" class="m-t-50">
                <!-- Nav tabs -->

                <!-- Error Response -->
                <div id="errors-container" class="alert alert-danger hide" role="alert">
                    <strong>Error: </strong> <span id="errors-value"></span>
                </div>
                <!-- End of Error Response -->

                <!-- Tab panes -->
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection