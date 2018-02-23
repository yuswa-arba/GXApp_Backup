@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')

<script src="{{mix('js/client/profile/notification.js')}}"></script>

@endpush

@section('content')

    <!-- START PAGE CONTENT -->
    <div class="content filter-container">
        <div id="vc-detail-notifications">
        </div>
    </div>
    <!-- END PAGE CONTENT -->

@endsection