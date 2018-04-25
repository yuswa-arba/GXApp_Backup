@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out80')
@endpush

@section('content')

            <div class="content">

            @include('pages.storage.inventory._menu_items')

                <!-- START CONTAINER FLUID -->
                <div class="container-fluid container-fixed-lg">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
                <!-- END CONTAINER FLUID -->
            </div>
            <!-- END PAGE CONTENT -->

@endsection