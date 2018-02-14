@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')

<script>


    $(document).ready(function() {

        // Sieve Search
        $('#filter-log-container').sieve({
            searchInput: $('#search-log-box'),
            itemSelector: ".filter-log"
        });

        $('.datepickerSearch').datepicker({ // datepicker
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('input[name="searchDate"]').change(function () { // event chenges search
            getData();
        });

        function getData() { // get data with ajax
            let dateSearch = $('input[name="searchDate"]').val();
            $.ajax({
                url : "/v1/h/developer/log/list?whereDate="+dateSearch,
                type: 'get',
                dataType : 'JSON',
                success : function (data) {
                    $('.listDataLogRequest').html('');
                    $('.listDataLogRequest').append(data);
                }
            });
        }
        getData();
    });


</script>


@include('layouts.partials.snippets._notification_to_zoom_out')
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
                        <li class="breadcrumb-item active">Log</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <div class="row">
                <div class="col-lg-4 col-xs-8 col-sm-8 m-b-10">
                    <div class="input-group date col-md-8 col-xs-12 col-sm-8 p-l-0 datepickerSearch">
                        <input type="text" name="searchDate" readonly value="{{ date('d/m/Y') }}" class="form-control"><span class="input-group-addon bg-primary text-white"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="col-md-12 m-b-20 bg-white">
                    <div class="card card-transparent">
                        <div class="card-header ">
                            <div class="card-title">Table List Job Request</div>
                            <div class="pull-right">
                                <div class="col-xs-12">
                                    <input type="text" id="search-log-box" class="form-control pull-right" placeholder="Search">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-block" id="filter-log-container">
                            <table class="table table-hover demo-table-search table-responsive-block table-list">
                                <thead>
                                <tr>
                                    <th style="width:10px;">ID</th>
                                    <th style="width:30px;">Causer</th>
                                    <th style="width:15px;">Via</th>
                                    <th style="width:15px;">Causer IP Adress</th>
                                    <th style="width:25px;">Subject</th>
                                    <th style="width:15px;">Action</th>
                                    <th style="width:10px;">Level</th>
                                    <th style="width:50px">Description</th>
                                    <th style="width:50px;">Created At</th>
                                </tr>
                                </thead>
                                <tbody class="listDataLogRequest">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection