@extends('layouts.main')

@push('child-styles')

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{asset('plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}"
        type="text/javascript"></script>
<script src="{{asset('plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/lodash.min.js')}}"></script>

@endpush

@push('child-page-controller')

<script src="{{mix('js/client/attendance/leave.js')}}"></script>
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
                        <li class="breadcrumb-item"><a href="{{route('attendance')}}">Attendance</a></li>
                        <li class="breadcrumb-item active">Leave</li>
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
            <div id="vc-attendance-leave"></div>
        </div>

    </div>

    <!-- END PAGE CONTENT -->

@endsection