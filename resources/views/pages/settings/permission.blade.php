@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<style>
    /* For scrollable modal */
    .modal-dialog {
        overflow-y: initial !important
    }

    .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }
</style>

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._zoom_out80')
<script src="{{mix('js/client/permission/main.js')}}"></script>
@endpush

@section('content')

    <div class="content" id="vc-role-permission">

        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active">Permission</li>
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
                    <div class="pull-right m-r-15">
                        <div class="">
                            <div class="dropdown dropdown-default">
                                <button class="btn btn-complete all-caps dropdown-toggle text-center" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Create new
                                </button>

                                <create-new-menus></create-new-menus>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-block">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                        <li class="nav-item">
                            <a href="#" class="active" data-toggle="tab" data-target="#by-users"><span>Users</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="" data-toggle="tab"
                               data-target="#by-roles"><span>Roles</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="tab" data-target="#by-permissions"><span>Permission</span></a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content bg-transparent filter-container">
                        <div class="tab-pane active" id="by-users">
                            <div class="card-block " id="">
                                <user-card></user-card>
                            </div>
                        </div>
                        <div class="tab-pane " id="by-roles">
                            <div class="card-block " id="">
                                <roles-card></roles-card>
                            </div>
                        </div>



                        <div class="tab-pane" id="by-permissions">
                            <div class="card-block">
                                <permissions-card></permissions-card>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END CONTAINER FLUID -->


        <!-- MODAL NEW ROLE -->
        <div class="modal fade stick-up disable-scroll" id="modal-new-role" tabindex="-1" role="dialog"
             aria-hidden="false">
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
                            <form role="form" id="form-create-role" method="post" action="{{route('v1.role.create')}}">
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
        <div class="modal fade stick-up disable-scroll" id="modal-new-permission" tabindex="-1" role="dialog"
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
                            <form role="form" id="form-create-permission" method="post"
                                  action="{{route('v1.permission.create')}}">
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
        <!-- END MODAL NEW PERMISSION -->


    {{--TODO--}}
    <!-- END MODAL USER -->
        <!-- MODAL DELETE PERMISSION -->
    {{--TODO--}}
    <!-- END MODAL ROLE & PERMISSION -->


    </div>
    <!-- END PAGE CONTENT -->



@endsection