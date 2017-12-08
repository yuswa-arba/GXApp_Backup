@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
<link href="{{mix('plugins/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>


@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
<script src="{{mix('plugins/js/autoNumeric.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{mix('plugins/js/jquery.validate.min.js')}}" type="text/javascript"></script>
@endpush

@push('child-page-controller')
@include('layouts.partials.snippets._notification_to_zoom_out')
<script src="{{mix('js/client/employee/form.js')}}"></script>
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
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm no-click" role="tablist"
                    data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active"
                           id="item-personal-info"
                           data-toggle="tab" href="#" role="tab"><i class="fa fa-user tab-icon"></i> <span>Personal Information</span></a>
                    </li>
                    <li class="nav-item">
                        <a class=""
                           id="item-employment"
                           data-toggle="tab" href="#" role="tab"><i
                                    class="fa fa-file-text tab-icon"></i> <span>Employment</span></a>
                    </li>
                </ul>

                <!-- Error Response -->
                <div id="errors-container" class="alert alert-danger hide" role="alert">
                    <strong>Error: </strong> <span id="errors-value"></span>
                </div>
                <!-- End of Error Response -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane slide-left padding-20 sm-no-padding active" id="tab-personal-info">
                        <form class="" role="form" id="personalInformationForm" enctype="multipart/form-data"
                              autocomplete="off">
                            <div class="row ">
                                <div class="col-md-6 b-r b-dashed b-grey ">
                                    <div class="padding-30 sm-padding-5">
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
                                            <div class="form-group form-group-default required">
                                                <label>Birth date <span
                                                            class="help fs-10">e.g. "25/12/2013"</span></label>
                                                <input id="birth-date" type="text"
                                                       class="form-control datepicker"
                                                       name="birthDate" value="{{old('birthDate')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Hometown </label>
                                                <input type="text" class="form-control" name="hometown"
                                                       value="{{old('hometown')}}" required>
                                            </div>

                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Education Level</label>
                                                <select class="full-width" data-placeholder="Select Education Level"
                                                        data-init-plugin="select2"
                                                        name="educationLevelId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($educationLevels as $edcLevel)
                                                        <option value="{{$edcLevel->id}}">{{$edcLevel->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Religion</label>
                                                <select class="full-width" data-placeholder="Select Religion"
                                                        data-init-plugin="select2"
                                                        name="religionId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($religions as $religion)
                                                        <option value="{{$religion->id}}">{{$religion->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="form-title">Contact Information</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default required">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address"
                                                       value="{{old('address')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city"
                                                       value="{{old('city')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="phoneNo"
                                                       value="{{old('phoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>E-mail Address<span
                                                            class="help fs-10">(Company e-mail address)</span></label>
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
                                        <p class="form-title">Marriage</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Marital Status"
                                                        data-init-plugin="select2"
                                                        name="maritalStatusId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Spouse's Name</label>
                                                <input type="text" class="form-control" name="spousesName"
                                                       value="{{old('spousesName')}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Number of Children</label>
                                                <input type="number" class="form-control" name="totalChildren"
                                                       value="{{old('totalChildren')}}">
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
                                                <label>Father's City</label>
                                                <input type="text" class="form-control" name="fatherCity"
                                                       value="{{old('fatherCity')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Father's Phone Number</label>
                                                <input type="number" class="form-control" name="fatherPhoneNo"
                                                       value="{{old('fatherPhoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Father's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Marital Status"
                                                        data-init-plugin="select2"
                                                        name="fatherMaritalStatusId"
                                                        required>
                                                    <option value="" disabled selected></option>
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
                                                <label>Mother's City</label>
                                                <input type="text" class="form-control" name="motherCity"
                                                       value="{{old('motherCity')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Mother's Phone Number</label>
                                                <input type="number" class="form-control" name="motherPhoneNo"
                                                       value="{{old('motherPhoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Mother's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Marital Status"
                                                        data-init-plugin="select2"
                                                        name="motherMaritalStatusId"
                                                        required>
                                                    <option disabled selected></option>
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
                                                <input type="number" class="form-control" name="siblingPhoneNo"
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
                                                <label>Sibling's City</label>
                                                <input type="text" class="form-control" name="siblingCity"
                                                       value="{{old('siblingCity')}}">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Sibling's Phone Number</label>
                                                <input type="number" class="form-control" name="siblingPhoneNo"
                                                       value="{{old('siblingPhoneNo')}}">
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label class="">Sibling's Marital Status</label>
                                                <select class="full-width" data-placeholder="Select Marital Status"
                                                        data-init-plugin="select2"
                                                        name="siblingMaritalStatusId">
                                                    <option value="" disabled selected></option>
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="col-md-6  ">
                                    <div class="padding-30 sm-padding-5">
                                        <p class="form-title">ID Card Information</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default required">
                                                <label>ID Card Number</label>
                                                <input type="text" class="form-control" name="idCardNumber"
                                                       value="{{old('idCardNumber')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>ID Card Photo </label>
                                                <input id="idCardPhoto"
                                                       type="file"
                                                       name="idCardPhoto"
                                                       accept="image/*"
                                                       required/>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="form-title">Contact Photo</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default required">
                                                <label>Contact Photo</label>
                                                <input type="file" name="employeePhoto" id="employeePhoto"
                                                       value="" required/>
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
                                                <select class="full-width" data-placeholder="Select Relationship"
                                                        data-init-plugin="select2"
                                                        name="emergencyRelationship"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    <option value="Family">Family</option>
                                                    <option value="Friend">Friend</option>
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="emergencyAddress"
                                                       value="{{old('emergencyAddress')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="emergencyCity"
                                                       value="{{old('emergencyCity')}}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Phone Number</label>
                                                        <input type="number" class="form-control"
                                                               name="emergencyPhoneNo"
                                                               value="{{old('emergencyPhoneNo')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default ">
                                                        <label>Alt. Phone Number</label>
                                                        <input type="number" class="form-control"
                                                               name="emergencyAltPhoneNo"
                                                               value="{{old('emergencyAltPhoneNo')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-default  ">
                                                <label>E-mail Address</label>
                                                <input type="email" class="form-control" name="emergencyEmailAddress"
                                                       value="{{old('emergencyEmailAddress')}}" >
                                            </div>
                                        </div>
                                        <br>
                                        <p class="form-title">Bank Information</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label class="">Bank</label>
                                                <select class="full-width" data-placeholder="Select Bank"
                                                        data-init-plugin="select2"
                                                        name="bankId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default ">
                                                <label>Bank Account Name</label>
                                                <input type="text" class="form-control" name="bankHolderName"
                                                       value="{{old('bankHolderName')}}">
                                            </div>
                                            <div class="form-group form-group-default ">
                                                <label>Bank Account Number</label>
                                                <input type="number" class="form-control" name="bankAccNo"
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
                                                <input type="number" class="form-control" name="prevCompanyPhoneNo"
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
                                                        <input type="text" class="form-control"
                                                               name="prevLengthEmployment"
                                                               value="{{old('prevLengthEmployment')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>


                                    </div>
                                    <button class="btn btn-outline-primary btn-block" id="createEmployeeBtn"
                                            type="button">Create
                                        Employee &
                                        Go to Employment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane slide-left padding-20 sm-no-padding" id="tab-employment">
                        <div class="row row-same-height">
                            <div class="col-md-7 b-r b-dashed b-grey ">
                                <div class="padding-30 sm-padding-5">
                                    {{--<span class="text-primary pointer" id="go-back-to-personal-tab"><i--}}
                                    {{--class="pg-arrow_left"></i>Go Back</span>--}}
                                    <p class="form-title">Employment Information</p>
                                    <form role="form" id="employmentForm">

                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Job Position</label>
                                                <select class="full-width" data-placeholder="Select Job Position"
                                                        data-init-plugin="select2"
                                                        name="jobPositionId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($jobPositions as $jobPosition)
                                                        <option value="{{$jobPosition->id}}">{{$jobPosition->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Division</label>
                                                <select class="full-width" data-placeholder="Select Division"
                                                        data-init-plugin="select2"
                                                        name="divisionId"
                                                        required
                                                >
                                                    <option value="" disabled selected></option>
                                                    @foreach($divisions as $division)
                                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Office Branch</label>
                                                <select class="full-width" data-placeholder="Select Branch Office"
                                                        data-init-plugin="select2"
                                                        name="branchOfficeId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($branchOffices as $branchOffice)
                                                        <option value="{{$branchOffice->id}}">{{$branchOffice->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label class="">Recruitment Status</label>
                                                <select class="full-width" data-placeholder="Select Recruitment Status"
                                                        data-init-plugin="select2"
                                                        name="recruitmentStatusId"
                                                        required
                                                >
                                                    <option value="" disabled selected></option>
                                                    @foreach($recruitmentStatuses as $recruitmentStatus)
                                                        <option value="{{$recruitmentStatus->id}}">{{$recruitmentStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Date of Entry </label>
                                                        <input id="date-of-entry" type="text"
                                                               class="form-control date datepicker"
                                                               name="dateOfEntry" value="{{old('dateOfEntry')}}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Date of Start </label>
                                                        <input id="date-of-start" type="text"
                                                               class="form-control date datepicker"
                                                               name="dateOfStart" value="{{old('dateOfStart')}}"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="padding-30 sm-padding-5 sm-m-t-15 ">
                                    <h2>Notice</h2>
                                    <p>After the completion of this form, an e-mail will be sent to the employee for
                                        account
                                        verification and account login details.</p>
                                    <p class="small hint-text">
                                        *If the e-mail is not received by the employee within the first 24 hours, a
                                        request should be made to the administrator to resend the verification
                                        e-mail.</p>
                                </div>
                                <button class="btn btn-outline-primary btn-block" id="saveEmploymentBtn">Save Employment
                                    & Send Verification
                                    Email
                                </button>

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