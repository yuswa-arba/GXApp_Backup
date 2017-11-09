@extends('layouts.main')
@push('child-styles')

@endpush

@push('child-scripts-plugins')

@endpush

@push('child-page-controller')
<script src="{{mix('client/passport/main.js')}}"></script>
@endpush
@section('content')

    <div class="content" id="passport-content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">API Passport</a></li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>

            </div>
        </div>
        <div class="container-fluid container-fixed-lg">
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>


@endsection