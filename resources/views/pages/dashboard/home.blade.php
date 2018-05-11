@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')

<script>
    $('#notify').click(function (e) {
        e.preventDefault()
        $.get('/testing/broadcast')
    })
</script>

@include('layouts.partials.snippets._notification_to_zoom_out80')

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
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        {{--<li class="breadcrumb-item active">Layout</li>--}}
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            {{--<button id="notify">Notify</button>--}}
            <div class="center-margin text-center p-t-200">
                <h2><b>Coming Soon!</b></h2>
                <h3> We are still not ready. Feature is currently being developed :)</h3>
            </div>

        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection