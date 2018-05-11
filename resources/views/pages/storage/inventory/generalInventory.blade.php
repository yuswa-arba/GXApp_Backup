@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{asset('plugins/js/sorttable.js')}}"></script>
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out80')
<script src="{{mix('js/client/storage/inventory/generalInventory.js')}}"></script>

@endpush

@section('content')

            <div class="content">

            @include('pages.storage.inventory._menu_items')

            <!-- START INNER CONTENT -->
                <div class="inner-content full-height">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                    <div class="filter-container">
                        <div id="vc-storage-inventory-general"></div>
                    </div>
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
                <!--END INNER CONTENT-->

            </div>
            <!-- END PAGE CONTENT -->

@endsection