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
        @include('layouts.partials.snippets._error_alert_1')
        <!-- START card -->
            <div class="card card-transparent">
                <div class="card-header ">
                    <div class="card-title dark-title">
                        Role & Permission List
                    </div>
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <input type="text" id="search-box" class="form-control pull-right"
                                   placeholder="Search">
                        </div>
                    </div>
                    <div class="pull-right m-r-15">
                        <div class="">
                            <div class="dropdown dropdown-default">
                                <button class="btn btn-complete all-caps dropdown-toggle text-center" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Create new
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" id="btnNewRole" data-toggle="modal"
                                       data-target="#modalNewRole">New Role</a>
                                    <a class="dropdown-item" href="#" id="btnNewPermission" data-toggle="modal"
                                       data-target="#modalNewPermission">New Permission </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-block">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                        <li class="nav-item">
                            <a href="#" class="active" data-toggle="tab"
                               data-target="#by-roles"><span>By Roles</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="" data-toggle="tab" data-target="#by-users"><span>By Users</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="tab" data-target="#by-permissions"><span>By Permission</span></a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content bg-transparent" id="card-filter">
                        <div class="tab-pane active" id="by-roles">
                            <div class="card-block " id="">
                                <div class="row">

                                    @foreach($roles as $role)
                                        <div class="col-lg-3   filter-item">
                                            <div class="card card-default ">
                                                <div class="card-header ">
                                                    <div class="card-title">
                                                        #{{$role->id}} {{$role->name}}
                                                        &nbsp;
                                                    </div>
                                                    <div class="card-controls">
                                                        <ul>
                                                            <li><a data-toggle="collapse" class="card-collapse"
                                                                   href="#"><i
                                                                            class="card-icon card-icon-collapse"></i></a>
                                                            </li>
                                                            <li><a data-toggle="refresh" class="card-refresh"
                                                                   href="#"><i
                                                                            class="card-icon card-icon-refresh"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">

                                                    <p class="hint-text fade small pull-left">
                                                        Total : {{count($role->permissions)}}
                                                        / {{count($permissions)}} Permissions</p>
                                                    <div class="clearfix"></div>
                                                    <div class="progress progress-small m-b-15 m-t-10">
                                                        <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                                        <div class="progress-bar progress-bar-primary"
                                                             style="width:{{round((int)count($role->permissions)/count($permissions) * 100)}}%"></div>
                                                        <!-- END BOOTSTRAP PROGRESS -->
                                                    </div>
                                                    <div class="scrollable">
                                                        <div class="scroll-h-70">
                                                            <p class="all-caps font-montserrat text-success bold smaller no-margin ">
                                                                @foreach($role->permissions as $permission)
                                                                    <i class="fa fa-circle small "></i> {{$permission->name}}
                                                                    &nbsp;
                                                                @endforeach
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-block">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane " id="by-users">
                            <div class="card-block " id="">
                                <div class="row">

                                    @foreach($users as $user)
                                        <div class="col-lg-3  filter-item">
                                            <div class="card card-default ">
                                                <div class="card-header ">
                                                    <div class="card-title">
                                                        {{$user->email}}
                                                        &nbsp;

                                                    </div>
                                                    <div class="card-controls">
                                                        <ul>
                                                            <li><a data-toggle="collapse" class="card-collapse"
                                                                   href="#"><i
                                                                            class="card-icon card-icon-collapse"></i></a>
                                                            </li>
                                                            <li><a data-toggle="refresh" class="card-refresh"
                                                                   href="#"><i
                                                                            class="card-icon card-icon-refresh"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <p class="hint-text fade small pull-left">
                                                        Total : {{count($user->permissions)}}
                                                        / {{count($permissions)}} Permissions</p>
                                                    <div class="clearfix"></div>
                                                    <div class="progress progress-small m-b-15 m-t-10">
                                                        <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                                        <div class="progress-bar progress-bar-primary"
                                                             style="width:{{round((int)count($role->permissions)/count($permissions) * 100)}}%"></div>
                                                        <!-- END BOOTSTRAP PROGRESS -->
                                                        <div class="scrollable">
                                                            <div class="scroll-h-70">
                                                                <p class="all-caps font-montserrat text-success bold smaller no-margin ">
                                                                    @foreach($user->permissions as $permission)
                                                                        <i class="fa fa-circle small "></i> {{$permission->name}}
                                                                        &nbsp;
                                                                    @endforeach
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-block">View Details</a>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="by-permissions">
                            <div class="card-block">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-lg-3  filter-item m-b-20">
                                            <div class=" card  no-margin widget-loader-circle todolist-widget pending-projects-widget">
                                                <div class="card-header ">
                                                    <div class="card-title">
                                                <span class="font-montserrat fs-11 all-caps dark-title">
                                                     #{{$permission->id}} {{$permission->name}}
                                                  </span>
                                                    </div>
                                                    <div class="card-controls">
                                                        <ul>
                                                            <li><a data-toggle="collapse" class="card-collapse"
                                                                   href="#"><i
                                                                            class="card-icon card-icon-collapse"></i></a>
                                                            </li>
                                                            <li><a href="#" class="card-refresh text-black"
                                                                   data-toggle="refresh"><i
                                                                            class="card-icon card-icon-refresh"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <ul class="nav nav-tabs nav-tabs-simple m-b-20" role="tablist"
                                                        data-init-reponsive-tabs="collapse">
                                                        <li class="nav-item"><a href="#role-tab{{$permission->id}}"
                                                                                class="active" data-toggle="tab"
                                                                                role="tab"
                                                                                aria-expanded="true">Role</a>
                                                        </li>
                                                        <li class="nav-item"><a href="#user-tab{{$permission->id}}"
                                                                                data-toggle="tab" role="tab"
                                                                                aria-expanded="false">User</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content no-padding">
                                                        <div class="tab-pane active" id="role-tab{{$permission->id}}">
                                                            <p class="hint-text fade small pull-left">
                                                                Total : {{count($permission->roles)}}
                                                                / {{count($roles)}} Roles </p>
                                                            <div class="clearfix"></div>
                                                            <div class="progress progress-small m-b-15 m-t-10">
                                                                <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                                                <div class="progress-bar progress-bar-primary"
                                                                     style="width:{{round((int)count($permission->roles)/count($roles) * 100)}}%"></div>
                                                                <!-- END BOOTSTRAP PROGRESS -->
                                                            </div>
                                                            <div class="scrollable">
                                                                <div class="scroll-h-50">
                                                                    <p class="all-caps font-montserrat text-success bold smaller no-margin ">
                                                                        @foreach($permission->roles as $role)
                                                                            <i class="fa fa-circle small "></i> {{$role->name}}
                                                                        @endforeach
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="user-tab{{$permission->id}}">
                                                            <p class="hint-text fade small pull-left">
                                                                Total : {{count($permission->users)}}
                                                                / {{count($users)}} Users </p>
                                                            <div class="clearfix"></div>
                                                            <div class="progress progress-small m-b-15 m-t-10">
                                                                <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                                                <div class="progress-bar progress-bar-warning"
                                                                     style="width:{{round((int)count($permission->users)/count($roles) * 100)}}%"></div>
                                                                <!-- END BOOTSTRAP PROGRESS -->
                                                            </div>
                                                            <div class="scrollable">
                                                                <div class="scroll-h-50">
                                                                    <p class="hint-text all-caps font-montserrat  text-warning small no-margin dark-title ">
                                                                        @foreach($permission->users as $user)
                                                                            <i class="fa fa-circle small "></i> {{$user->name}}
                                                                        @endforeach
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-block">View Details</a>

                                                </div>
                                            </div>
                                            <!-- END WIDGET -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END CONTAINER FLUID -->

    </div>
    <!-- END PAGE CONTENT -->

    <!-- MODAL NEW ROLE -->
    <div class="modal fade stick-up disable-scroll" id="modalNewRole" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                    class="pg-close fs-14"></i>
                        </button>
                        <h5>Create New Role</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="form-create-role" method="post" action="{{route('bv1.role.create')}}">
                            {{csrf_field()}}
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Role Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class=" col-md-4 m-t-10 sm-m-t-10">
                                    <button type="submit" class="btn btn-primary btn-block m-t-5">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- EMD MODAL NEW ROLE -->

    <!-- MODAL NEW PERMISSION -->
    <div class="modal fade stick-up disable-scroll" id="modalNewPermission" tabindex="-1" role="dialog"
         aria-hidden="false">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                    class="pg-close fs-14"></i>
                        </button>
                        <h5>Create New Permission</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="form-create-permission" method="post" action="{{route('bv1.permission.create')}}">
                            {{csrf_field()}}
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Permission Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class=" col-md-4 m-t-10 sm-m-t-10">
                                    <button type="submit" class="btn btn-primary btn-block m-t-5">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- EMD MODAL NEW PERMISSION -->




@endsection