@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<link href="{{asset('plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{asset('plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/lodash.min.js')}}"></script>

@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._notification_to_zoom_out80')

<script src="{{mix('js/client/attendance/setting.js')}}"></script>
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
                                <li class="breadcrumb-item active">Settings</li>
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
                    <div id="vc-attendance-setting"></div>
                </div>


            </div>
            <!-- END PAGE CONTENT -->

@endsection