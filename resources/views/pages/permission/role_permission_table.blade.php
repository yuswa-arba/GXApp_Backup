@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<link href="{{asset('plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet"
      type="text/css"/>
<link href="{{asset('plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}"
      rel="stylesheet" type="text/css"/>
<link href="{{asset('plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css"
      media="screen"/>

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{asset('plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}"
        type="text/javascript"></script>
<script src="{{asset('plugins/datatables-responsive/js/datatables.responsive.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/datatables-responsive/js/lodash.min.js')}}" type="text/javascript"></script>
@endpush

@push('child-page-controller')
<script src="{{asset('client/permission/permissionPageController.js')}}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="content">
        @include('pages.permission._menu_permission_control')
        <!-- START INNER CONTENT -->
        <div class="inner-content full-height">
            <!-- START JUMBOTRON -->
            <div class="jumbotron" data-pages="parallax">
                <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                    <div class="inner">
                        <!-- START BREADCRUMB -->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Permission Control</a></li>
                            <li class="breadcrumb-item active">Roles & Permission</li>

                        </ol>
                        <!-- END BREADCRUMB -->
                    </div>
                </div>
            </div>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START card -->
                <div class="card card-transparent">
                    <div class="card-header ">
                        <div class="card-title dark-title">Role & Permission Table
                        </div>
                        <div class="pull-right">
                            <div class="col-xs-12">
                                <input type="text" id="search-table" class="form-control pull-right"
                                       placeholder="Search">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-block">
                        <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Permission</th>
                                <th>Actions</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role_permissions as $role_permission)
                                <tr>
                                    <td>
                                        {{$role_permission['role_id']}}
                                    </td>
                                    <td class="bold text-uppercase">{{$role_permission['role']}}</td>
                                    <td>
                                        <label for="" class="label label-primary">
                                            {{count($role_permission['permission'] )}}
                                        </label> <br>
                                        @foreach($role_permission['permission'] as $permission)
                                            <small>{{$permission['name']}}</small>,
                                        @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-danger">Edit</button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!--END INNER CONTENT-->
    </div>
    <!-- END PAGE CONTENT -->

@endsection