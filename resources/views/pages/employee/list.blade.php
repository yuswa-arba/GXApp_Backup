@extends('layouts.main')

@push('child-styles')
@endpush

@push('child-scripts-plugins')
@endpush

@push('child-page-controller')
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
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>
        </div>

        <div class="filter-container">
            <div id="vc-employee-list"></div>
        </div>



        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection