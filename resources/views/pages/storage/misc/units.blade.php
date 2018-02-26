@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._notification_to_zoom_out80')
<script src="{{mix('js/client/storage/misc/units.js')}}"></script>
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
                        <li class="breadcrumb-item"><a href="#">Storage</a></li>
                        <li class="breadcrumb-item "><a href="#">Misc</a></li>
                        <li class="breadcrumb-item active">Units</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->

        <div class="filter-container">
            <div id="vc-storage-misc-units"></div>
        </div>

    </div>
    <!-- END PAGE CONTENT -->

@endsection