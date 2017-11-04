@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{asset('plugins/js/jquery.sieve.min.js')}}" type="text/javascript"></script>
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
            <div class="container-fluid container-fixed-lg">
                <!-- START card -->
                <div class="card card-transparent">
                    <div class="card-header ">
                        <div class="card-title dark-title">Role & Permission Table
                        </div>
                        <div class="pull-right">
                            <div class="col-xs-12">
                                <input type="text" id="search-box" class="form-control pull-right"
                                       placeholder="Search">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-block" id="card-filter">
                        <div class="row">

                            @foreach($role_permissions as $role_permission)
                                <div class="col-lg-4  filter-item">
                                    <div class="card card-default card-linear">
                                        <div class="card-header ">
                                            <div class="card-title">
                                                #{{$role_permission['role_id']}} {{$role_permission['role']}}
                                                &nbsp;
                                                <span><i class="fa fa-pencil pointer"></i></span>
                                            </div>
                                            <div class="card-controls">
                                                <ul>
                                                    <li><a data-toggle="collapse" class="card-collapse" href="#"><i
                                                                    class="card-icon card-icon-collapse"></i></a>
                                                    </li>
                                                    <li><a data-toggle="refresh" class="card-refresh" href="#"><i
                                                                    class="card-icon card-icon-refresh"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="scrollable">
                                                <div class="demo-card-scrollable">
                                                    <button class="btn btn-primary m-b-10">
                                                        Total :
                                                    <span class="bold">
                                                         {{count($role_permission['permission'] )}}
                                                    </span>
                                                    </button>

                                                    @foreach($role_permission['permission'] as $permission)
                                                        <label class="label label-default">{{$permission['name']}}</label>
                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>


                        {{--<table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                        {{--<th>ID</th>--}}
                        {{--<th>Role</th>--}}
                        {{--<th>Permission</th>--}}
                        {{--<th>Actions</th>--}}

                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--@foreach($role_permissions as $role_permission)--}}
                        {{--<tr>--}}
                        {{--<td>--}}
                        {{--{{$role_permission['role_id']}}--}}
                        {{--</td>--}}
                        {{--<td class="bold text-uppercase">{{$role_permission['role']}}</td>--}}
                        {{--<td>--}}
                        {{--<label for="" class="label label-primary">--}}
                        {{--{{count($role_permission['permission'] )}}--}}
                        {{--</label> <br>--}}
                        {{--@foreach($role_permission['permission'] as $permission)--}}
                        {{--<small>{{$permission['name']}}</small>,--}}
                        {{--@endforeach--}}
                        {{--</td>--}}
                        {{--<td>--}}
                        {{--<button class="btn btn-danger">Edit</button>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}

                        {{--</tbody>--}}

                        {{--</table>--}}
                    </div>
                </div>
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!--END INNER CONTENT-->
    </div>
    <!-- END PAGE CONTENT -->

@endsection