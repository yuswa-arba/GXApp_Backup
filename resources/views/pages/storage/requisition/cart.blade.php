@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out80')
<script src="{{mix('js/client/storage/requisition/cart.js')}}"></script>
@endpush

@section('content')

            <div class="content">
                <!-- START JUMBOTRON -->
                {{--<div class="jumbotron" data-pages="parallax">--}}
                    {{--<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">--}}
                        {{--<div class="inner">--}}
                            {{--<!-- START BREADCRUMB -->--}}
                            {{--<ol class="breadcrumb">--}}
                                {{--<li class="breadcrumb-item"><a href="#">Storage</a></li>--}}
                                {{--<li class="breadcrumb-item"><a href="#">Requisition</a></li>--}}
                                {{--<li class="breadcrumb-item active">Shop</li>--}}
                            {{--</ol>--}}
                            {{--<!-- END BREADCRUMB -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <!-- END JUMBOTRON -->


                <div class="filter-container">
                    <div id="vc-storage-requisition-cart"></div>
                </div>

            </div>
            <!-- END PAGE CONTENT -->

@endsection