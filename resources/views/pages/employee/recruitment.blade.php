@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<link href="{{mix('plugins/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{mix('plugins/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{mix('plugins/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{asset('plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css"/>

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{mix('plugins/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/classie.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/autoNumeric.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/dropzone/dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>

@endpush

@push('child-page-controller')
<script src="{{asset('client/employee/recruitmentPageController.js')}}" type="text/javascript"></script>
@endpush


@section('content')
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
    @include('layouts.partials._navigation')
    <!-- START PAGE CONTENT WRAPPER -->
        <div class="page-content-wrapper">
            <!-- START PAGE CONTENT -->
            <div class="content">
                <!-- START JUMBOTRON -->
                <div class="jumbotron" data-pages="parallax">
                    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                        <div class="inner">
                            <!-- START BREADCRUMB -->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('employee.list')}}">Employee</a></li>
                                <li class="breadcrumb-item active">Recruitment</li>
                            </ol>
                            <!-- END BREADCRUMB -->
                        </div>
                    </div>
                </div>
                <!-- END JUMBOTRON -->
                <!-- START CONTAINER FLUID -->
                <div class="container-fluid container-fixed-lg">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                    <div id="rootwizard" class="m-t-50">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist"
                            data-init-reponsive-tabs="dropdownfx">
                            <li class="nav-item">
                                <a class="active" data-toggle="tab" href="#tab1" role="tab"><i
                                            class="fa fa-user tab-icon"></i> <span>Personal Information</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="" data-toggle="tab" href="#tab2" role="tab"><i
                                            class="fa fa-truck tab-icon"></i> <span>Shipping information</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="" data-toggle="tab" href="#tab3" role="tab"><i
                                            class="fa fa-credit-card tab-icon"></i> <span>Payment details</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="" data-toggle="tab" href="#tab4" role="tab"><i
                                            class="fa fa-check tab-icon"></i> <span>Summary</span></a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane slide-left padding-20 sm-no-padding active" id="tab1">
                                <div class="row row-same-height">
                                    <div class="col-md-6 b-r b-dashed b-grey ">
                                        <div class="padding-30 sm-padding-5">
                                            <form class="" role="form">
                                                <p class="form-title">Private Information</p>
                                                <div class="form-group-attached">
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="form-group form-group-default required">
                                                                <label>Surname</label>
                                                                <input type="text" class="form-control">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default required">
                                                                <label>Given name</label>
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default required">
                                                                <label>Nickname</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                                <label class="">Gender</label>
                                                                <select class="full-width"
                                                                        data-placeholder="Select Country"
                                                                        data-init-plugin="select2">
                                                                    <option value="1">Male</option>
                                                                    <option value="2">Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default required">
                                                                <label>Birth date</label>
                                                                <input id="start-date" type="text"
                                                                       class="form-control date"
                                                                       name="startDate" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default required">
                                                                <label>Hometown</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Education Level</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Elementary School</option>
                                                            <option value="1">Junior High School</option>
                                                            <option value="2">Senior High School</option>
                                                            <option value="2">Associate's Degree</option>
                                                            <option value="2">Bachelor's Degree</option>
                                                            <option value="2">Master's Degree</option>
                                                            <option value="2">Doctorate's Degree</option>


                                                        </select>
                                                    </div>


                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Religion</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Christianity</option>
                                                            <option value="2">Islam</option>
                                                            <option value="2">Catholicism</option>
                                                            <option value="2">Buddhism</option>
                                                            <option value="2">Hinduism</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <p class="form-title">Marriage</p>
                                                <div class="form-group-attached">
                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Marital Status</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Married</option>
                                                            <option value="1">Remarried</option>
                                                            <option value="2">Divorced</option>
                                                            <option value="2">Widowed</option>
                                                            <option value="2">Unmarried</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Spouse's Name</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Number of Children</label>
                                                        <input type="number" class="form-control" required>
                                                    </div>

                                                </div>
                                                <br>
                                                <p class="form-title">Family</p>
                                                <div class="form-group-attached">
                                                    <div class="form-group form-group-default required">
                                                        <label>Father's Name</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Father's Address</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Father's Phone Number</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Father's Marital Status</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Married</option>
                                                            <option value="1">Remarried</option>
                                                            <option value="2">Divorced</option>
                                                            <option value="2">Widowed</option>
                                                            <option value="2">Unmarried</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group-attached">
                                                    <div class="form-group form-group-default required">
                                                        <label>Mother's Name</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Mother's Address</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Mother's Phone Number</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Mother's Marital Status</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Married</option>
                                                            <option value="1">Remarried</option>
                                                            <option value="2">Divorced</option>
                                                            <option value="2">Widowed</option>
                                                            <option value="2">Unmarried</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group-attached">
                                                    <div class="form-group form-group-default">
                                                        <label>Number of Siblings</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group form-group-default">
                                                        <label>Sibling's Name</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group form-group-default">
                                                        <label>Sibling's Address</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group form-group-default">
                                                        <label>Sibling's Phone Number</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group form-group-default form-group-default-select2">
                                                        <label class="">Sibling's Marital Status</label>
                                                        <select class="full-width" data-placeholder="Select Country"
                                                                data-init-plugin="select2">
                                                            <option value="1">Married</option>
                                                            <option value="1">Remarried</option>
                                                            <option value="2">Divorced</option>
                                                            <option value="2">Widowed</option>
                                                            <option value="2">Unmarried</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6  ">
                                        <div class="padding-30 sm-padding-5">
                                            <p class="form-title">Contact Information</p>
                                            <div class="form-group-attached">
                                                <div class="form-group form-group-default required">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>Phone Number</label>
                                                    <input type="number" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>E-mail Address</label>
                                                    <input type="email" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default ">
                                                    <label>Alt. E-mail Address</label>
                                                    <input type="email" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <p class="form-title">Emergency Contact Information</p>
                                            <div class="form-group-attached">
                                                <div class="form-group form-group-default required">
                                                    <label>Contact Person Name</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default form-group-default-select2 required">
                                                    <label class="">Relationship</label>
                                                    <select class="full-width" data-placeholder="Select Country"
                                                            data-init-plugin="select2">
                                                        <option value="1">Family</option>
                                                        <option value="1">Friend</option>
                                                    </select>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default required">
                                                            <label>Phone Number</label>
                                                            <input type="number" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default ">
                                                            <label>Alt. Phone Number</label>
                                                            <input type="number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-default ">
                                                    <label>E-mail Address</label>
                                                    <input type="number" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <p class="form-title">ID Card Information</p>
                                            <div class="form-group-attached">
                                                <div class="form-group form-group-default required">
                                                    <label>ID Card Number</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default ">
                                                    <label>ID Card Photo</label>
                                                    <form action="/file-upload" class="dropzone no-margin">
                                                        <div class="fallback">
                                                            <input name="file" type="file" multiple/>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
                                            <p class="form-title">Bank Information</p>
                                            <div class="form-group-attached">
                                                <div class="form-group form-group-default required">
                                                    <label>Bank Name</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>Bank Account Name</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>Bank Account Number</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>Bank Branch</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                                <div class="form-group form-group-default required">
                                                    <label>City</label>
                                                    <input type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20 sm-no-padding" id="tab2">
                                <div class="row row-same-height">
                                    <div class="col-md-5 b-r b-dashed b-grey ">
                                        <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-50">
                                            <h2>Your Information is safe with us!</h2>
                                            <p>We respect your privacy and protect it with strong encryption, plus
                                                strict
                                                policies . Two-step verification, which we encourage all our
                                                customers
                                                to
                                                use.</p>
                                            <p class="small hint-text">Below is a sample page for your cart ,
                                                Created
                                                using
                                                pages design UI Elementes</p>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="padding-30 sm-padding-5">
                                            <form role="form">
                                                <p>Name and Email Address</p>
                                                <div class="form-group-attached">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default required">
                                                                <label>First name</label>
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Last name</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-default required">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
                <!-- END CONTAINER FLUID -->
            </div>
            <!-- END PAGE CONTENT -->
            @include('layouts.partials._footer_in_page')
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    @include('layouts.partials._quickview')
    @include('layouts.partials._overlay')
@endsection