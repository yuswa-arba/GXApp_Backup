@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out90')
{{--<script>--}}
    {{--$('#notify').click(function(e){--}}
        {{--e.preventDefault()--}}
        {{--$.get('/testing/broadcast')--}}
    {{--})--}}
{{--</script>--}}
<script src="{{mix('js/client/developer/fingerspot.js')}}"></script>

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
                        <li class="breadcrumb-item"><a href="#">Developer</a></li>
                        <li class="breadcrumb-item active">Fingerspot</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div id="vc-developer-fingerspot"></div>

        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection