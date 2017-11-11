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
<script src="{{mix('plugins/js/autoNumeric.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/dropzone/dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>

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
                                    class="fa fa-file-text tab-icon"></i> <span>Employment</span></a>
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
                                                        <input type="text" class="form-control" name="surname"
                                                               value="{{old('surname')}}" required>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Given name</label>
                                                        <input type="text" class="form-control" name="givenName"
                                                               value="{{old('givenName')}}" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Nickname</label>
                                                        <input type="text" class="form-control" name="nickName"
                                                               value="{{old('nickName')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default form-group-default-select2 required">
                                                        <label class="">Gender</label>
                                                        <select class="full-width"
                                                                data-placeholder="Select Country"
                                                                data-init-plugin="select2"
                                                                name="gender"
                                                        >
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Birth date</label>
                                                        <input id="birth-date" type="text"
                                                               class="form-control date"
                                                               name="birthDate" value="{{old('birthDate')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Hometown</label>
                                                        <input type="text" class="form-control" name="city"
                                                               value="{{old('city')}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Education Level</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="educationLevelId"
                                                        required
                                                >
                                                    @foreach($educationLevels as $edcLevel)
                                                        <option value="{{$edcLevel->id}}">{{$edcLevel->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Religion</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="religionId"
                                                        required
                                                >
                                                    @foreach($religions as $religion)
                                                        <option value="{{$religion->id}}">{{$religion->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="form-title">Marriage</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="maritalStatusId"
                                                        required>
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Spouse's Name</label>
                                                <input type="text" class="form-control" name="spousesName"
                                                       value="{{old('spousesName')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Number of Children</label>
                                                <input type="number" class="form-control" name="totalChildren"
                                                       value="{{old('totalChildren')}}" required>
                                            </div>

                                        </div>
                                        <br>
                                        <p class="form-title">Family</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default required">
                                                <label>Father's Name</label>
                                                <input type="text" class="form-control" name="fatherName"
                                                       value="{{old('fatherName')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Father's Address</label>
                                                <input type="text" class="form-control" name="fatherAddress"
                                                       value="{{old('fatherAddress')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Father's Phone Number</label>
                                                <input type="text" class="form-control" name="fatherPhoneNo"
                                                       value="{{old('fatherPhoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Father's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="fatherMaritalStatusId"
                                                        required
                                                >
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default required">
                                                <label>Mother's Name</label>
                                                <input type="text" class="form-control" name="motherName"
                                                       value="{{old('motherName')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Mother's Address</label>
                                                <input type="text" class="form-control" name="motherAddress"
                                                       value="{{old('motherAddress')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Mother's Phone Number</label>
                                                <input type="text" class="form-control" name="motherPhoneNo"
                                                       value="{{old('motherPhoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Mother's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="motherMaritalStatusId"
                                                        required
                                                >
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default">
                                                <label>Number of Siblings</label>
                                                <input type="text" class="form-control" name="siblingPhoneNo"
                                                       value="{{old('siblingPhoneNo')}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Sibling's Name</label>
                                                <input type="text" class="form-control" name="siblingName"
                                                       value="{{old('siblingName')}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Sibling's Address</label>
                                                <input type="text" class="form-control" name="siblingAddress"
                                                       value="{{old('siblingAddress')}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Sibling's Phone Number</label>
                                                <input type="text" class="form-control" name="siblingPhoneNo"
                                                       value="{{old('siblingPhoneNo')}}">
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label class="">Sibling's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Country"
                                                        data-init-plugin="select2"
                                                        name="siblingMaritalStatusId"
                                                >
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
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
                                            <input type="text" class="form-control" name="address"
                                                   value="{{old('address')}}" required>
                                        </div>
                                        <div class="form-group form-group-default required">
                                            <label>Phone Number</label>
                                            <input type="number" class="form-control" name="phoneNo"
                                                   value="{{old('phoneNo')}}" required>
                                        </div>
                                        <div class="form-group form-group-default required">
                                            <label>E-mail Address</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="{{old('email')}}" required>
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Alt. E-mail Address</label>
                                            <input type="email" class="form-control" name="altEmail"
                                                   value="{{old('altEmail')}}">
                                        </div>
                                    </div>
                                    <br>
                                    <p class="form-title">Contact Photo</p>
                                    <div class="form-group-attached">
                                        <div class="form-group form-group-default required">
                                            <label>Contact Photo</label>
                                            <form action="/file-upload" class="dropzone no-margin">
                                                <div class="fallback">
                                                    <input type="file" name="employeePhoto"
                                                           value="{{old('employeePhoto')}}" required/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="form-title">Emergency Contact Information</p>
                                    <div class="form-group-attached">
                                        <div class="form-group form-group-default required">
                                            <label>Contact Person Name</label>
                                            <input type="text" class="form-control" name="emergencyContact"
                                                   value="{{old('emergencyContact')}}" required>
                                        </div>
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label class="">Relationship</label>
                                            <select class="full-width" data-placeholder="Select Country"
                                                    data-init-plugin="select2"
                                                    name="emergencyRelationship"
                                                    required
                                            >
                                                <option value="1">Family</option>
                                                <option value="1">Friend</option>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-default required">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="emergencyAddress"
                                                   value="{{old('emergencyAddress')}}" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default required">
                                                    <label>Phone Number</label>
                                                    <input type="number" class="form-control" name="emergencyPhoneNo"
                                                           value="{{old('emergencyPhoneNo')}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Alt. Phone Number</label>
                                                    <input type="number" class="form-control" name="emergencyAltPhoneNo"
                                                           value="{{old('emergencyAltPhoneNo')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>E-mail Address</label>
                                            <input type="email" class="form-control" name="emergencyEmailAddress"
                                                   value="{{old('emergencyEmailAddress')}}" required>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="form-title">Previous Employment Information</p>
                                    <div class="form-group-attached">
                                        <div class="form-group form-group-default ">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" name="prevCompanyName"
                                                   value="{{old('prevCompanyName')}}">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Company Address</label>
                                            <input type="text" class="form-control" name="prevCompanyAddress"
                                                   value="{{old('prevCompanyAddress')}}">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Company Phone Number</label>
                                            <input type="text" class="form-control" name="prevCompanyPhoneNo"
                                                   value="{{old('prevCompanyPhoneNo')}}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Position</label>
                                                    <input type="text" class="form-control" name="prevPosition"
                                                           value="{{old('prevPosition')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Length of Employment</label>
                                                    <input type="text" class="form-control" name="prevLengthEmployment"
                                                           value="{{old('prevLengthEmployment')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="form-title">ID Card Information</p>
                                    <div class="form-group-attached">
                                        <div class="form-group form-group-default required">
                                            <label>ID Card Number</label>
                                            <input type="text" class="form-control" name="idCardNumber"
                                                   value="{{old('idCardNumber')}}" required>
                                        </div>
                                        <div class="form-group form-group-default required">
                                            <label>ID Card Photo</label>
                                            <form action="/file-upload" class="dropzone no-margin">
                                                <div class="fallback">
                                                    <input type="file" name="idCardPhoto" value="{{old('idCardPhoto')}}"
                                                           required/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="form-title">Bank Information</p>
                                    <div class="form-group-attached">
                                        <div class="form-group form-group-default ">
                                            <label>Bank Name</label>
                                            <input type="text" class="form-control" name="bankId">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Bank Account Name</label>
                                            <input type="text" class="form-control" name="bankHolderName"
                                                   value="{{old('bankHolderName')}}">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Bank Account Number</label>
                                            <input type="text" class="form-control" name="bankAccNo"
                                                   value="{{old('bankAccNo')}}">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>Bank Branch</label>
                                            <input type="text" class="form-control" name="bankBranch"
                                                   value="{{old('bankBranch')}}">
                                        </div>
                                        <div class="form-group form-group-default ">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="bankCity"
                                                   value="{{old('bankCity')}}">
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

@endsection