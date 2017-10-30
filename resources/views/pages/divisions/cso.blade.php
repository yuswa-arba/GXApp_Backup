@extends('layouts.main')
@section('content')
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
    @include('layouts.partials._navigation')
    <!-- START PAGE CONTENT WRAPPER -->
        <div class="page-content-wrapper">
            <!-- START PAGE CONTENT -->
            <div class="content">
            @include('pages.divisions._menu_cso')
                <!-- START CONTAINER FLUID -->
                <div class="container-fluid container-fixed-lg">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
                <!-- END CONTAINER FLUID -->
            </div>
            <!-- END PAGE CONTENT -->

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    @include('layouts.partials._quickview')
    @include('layouts.partials._overlay')
@endsection