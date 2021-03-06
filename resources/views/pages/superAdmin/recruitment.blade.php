@extends('layouts.main_no_sidebar')

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
@include('layouts.partials.snippets._zoom_out90')
<script src="{{mix('js/client/superadmin/recruitment.js')}}"></script>
@endpush

@section('content')

    <!-- START PAGE CONTENT -->
    <div class="content no-padding">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('superadmin.index')}}">Superadmin</a></li>
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
            <div id="rootwizard" class="">
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
                           id="item-medical-records"
                           data-toggle="tab" href="#" role="tab"><i class="fa fa-user-md tab-icon"></i> <span>Medical Records</span></a>
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
                        <!-- Start of Personal Tab -->
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
                                                    <div class="form-group form-group-default required">
                                                        <label class="">Gender</label>
                                                        <select class="form-control"
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

                                            <div class="form-group form-group-default required">
                                                <label class="">Education Level</label>
                                                <select class="form-control"
                                                        name="educationLevelId"
                                                        required>
                                                    <option value="" disabled selected hidden>Select Education</option>
                                                    @foreach($educationLevels as $edcLevel)
                                                        <option value="{{$edcLevel->id}}">{{$edcLevel->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group form-group-default  required">
                                                <label class="">Religion</label>
                                                <select class="form-control"
                                                        name="religionId"
                                                        required>
                                                    <option value="" disabled selected hidden>Select Religion</option>
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
                                                <input type="number" min="0" class="form-control" name="phoneNo"
                                                       value="{{old('phoneNo')}}" required>
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>E-mail Address<span
                                                            class="help fs-10">(Active e-mail address)</span></label>
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
                                            <div class="form-group form-group-default  required">
                                                <label class="">Marital Status</label>
                                                <select class="form-control"
                                                        name="maritalStatusId"
                                                        required>
                                                    <option value="" disabled selected hidden>Select Status</option>
                                                    @foreach($maritalStatuses as $maritalStatus)
                                                        <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="spouse-form">
                                                <div class="form-group form-group-default">
                                                    <label>Spouse's Name</label>
                                                    <input type="text" class="form-control" name="spousesName"
                                                           value="{{old('spousesName')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Number of Children</label>
                                                    <input type="number" min="0" class="form-control"
                                                           name="totalChildren"
                                                           value="{{old('totalChildren')}}">
                                                </div>
                                            </div>


                                        </div>
                                        <br>
                                        <p class="form-title">Family</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default  required">
                                                <label class="">Father is deceased?</label>
                                                <select class="form-control"
                                                        name="fatherIsDeceased"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <div id="father-form">
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
                                                    <input type="number" min="0" class="form-control"
                                                           name="fatherPhoneNo"
                                                           value="{{old('fatherPhoneNo')}}" required>
                                                </div>
                                                <div class="form-group form-group-default  required">
                                                    <label class="">Father's Marital Status</label>
                                                    <select class="form-control"
                                                            name="fatherMaritalStatusId"
                                                            required>
                                                        <option value="" disabled selected hidden>Select Status</option>
                                                        @foreach($maritalStatuses as $maritalStatus)
                                                            <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                        <br>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default  required">
                                                <label class="">Mother is deceased?</label>
                                                <select class="form-control"
                                                        name="motherIsDeceased"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <div id="mother-form">
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
                                                    <input type="number" min="0" class="form-control"
                                                           name="motherPhoneNo"
                                                           value="{{old('motherPhoneNo')}}" required>
                                                </div>
                                                <div class="form-group form-group-default  required">
                                                    <label class="">Mother's Marital Status</label>
                                                    <select class="form-control"
                                                            name="motherMaritalStatusId"
                                                            required>
                                                        <option value="" disabled selected hidden>Select Status</option>
                                                        @foreach($maritalStatuses as $maritalStatus)
                                                            <option value="{{$maritalStatus->id}}">{{$maritalStatus->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <br>
                                        <div class="form-group form-group-default">
                                            <label>Number of Siblings</label>
                                            <input type="number" min="0" maxlength="1" max="10"
                                                   placeholder="(max: 10)"
                                                   class="form-control" name="numberOfSiblings"
                                                   value="{{old('numberOfSiblings')}}">
                                        </div>
                                        <div class="form-group-attached">
                                            <div class="hide" id="siblingsForm">
                                                <br>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Name</label>
                                                    <input type="text" class="form-control" name="siblingName[]"
                                                           value="{{old('siblingName')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Address</label>
                                                    <input type="text" class="form-control" name="siblingAddress[]"
                                                           value="{{old('siblingAddress')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's City</label>
                                                    <input type="text" class="form-control" name="siblingCity[]"
                                                           value="{{old('siblingCity')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Phone Number</label>
                                                    <input type="number" min="0" class="form-control"
                                                           name="siblingPhoneNo[]"
                                                           value="{{old('siblingPhoneNo')}}">
                                                </div>
                                                <br>
                                            </div>

                                            <div id="siblingsFormContainer">

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
                                                <input type="number" min="0" maxlength="16" class="form-control"
                                                       name="idCardNumber"
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
                                                <label>Contact Photo <span class="help fs-10">(Best Display : 158px x 158px)</span></label>
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
                                            <div class="form-group form-group-default  required">
                                                <label class="">Relationship</label>
                                                <select class="form-control"
                                                        name="emergencyRelationship"
                                                        required>
                                                    <option value="" disabled selected hidden>Select Relationship
                                                    </option>
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
                                                        <input type="number" min="0" class="form-control"
                                                               name="emergencyPhoneNo"
                                                               value="{{old('emergencyPhoneNo')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default ">
                                                        <label>Alt. Phone Number</label>
                                                        <input type="number" min="0" class="form-control"
                                                               name="emergencyAltPhoneNo"
                                                               value="{{old('emergencyAltPhoneNo')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-default  ">
                                                <label>E-mail Address</label>
                                                <input type="email" class="form-control" name="emergencyEmailAddress"
                                                       value="{{old('emergencyEmailAddress')}}">
                                            </div>
                                        </div>
                                        <br>
                                        <p class="form-title">Bank Information</p>
                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default ">
                                                <label class="">Bank</label>
                                                <select class="form-control"
                                                        name="bankId"
                                                        required>
                                                    <option value="" disabled selected hidden>Select Bank</option>
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
                                                <input type="number" min="0" class="form-control" name="bankAccNo"
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
                                                <input type="number" min="0" class="form-control"
                                                       name="prevCompanyPhoneNo"
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
                                                        <input type="radio" name="lengthEmploymentTimeFormat"
                                                               value="years" checked> Year(s)
                                                        <input type="radio" name="lengthEmploymentTimeFormat"
                                                               value="months"> Month(s)
                                                        <br>
                                                        <input type="number" class="form-control"
                                                               placeholder="1"
                                                               min="0"
                                                               name="prevLengthEmployment"
                                                               value="{{old('prevLengthEmployment')}}">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <br>


                                    </div>
                                    <button class="btn btn-outline-primary btn-block" id="createEmployeeBtn"
                                            type="button">Create Employee
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- End of Personal Tab -->

                    <div class="tab-pane slide-left padding-20 sm-no-padding" id="tab-medical-records">
                        <!-- Start of Medical Records Tab -->
                        <form class="" role="form" id="medicalRecordsForm" autocomplete="off">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Long term medication</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="hasLongTermMedication"
                                                           id="treatment-on">
                                                    <label for="treatment-on">Yes</label>
                                                    <input type="radio" value="0" name="hasLongTermMedication"
                                                           checked="checked" id="treatment-off">
                                                    <label for="treatment-off">No</label>
                                                </div>
                                            </div>
                                            <div class="row  padding-5 form-group form-group-attached disabled"
                                                 id="treatmentQuestion" style="display: none;">
                                                <div class="form-group form-group-default">
                                                    <label class="label-sm">Type of disease</label>
                                                    <input type="text" class="form-control"
                                                           name="typeOfDisease"
                                                           placeholder="Type of disease" required>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label class="label-sm">Since When</label>
                                                    <input type="text"
                                                           name="medicationSinceWhen"
                                                           class="form-control datepickerGet"
                                                           placeholder="dd/mm/yyyy" required>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label class="col-form-label-sm">Type of Drug</label>
                                                    <input type="text"
                                                           name="typeOfDrug"
                                                           class="form-control" placeholder="Type of drug"
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Are you a smoker?</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="isASmoker" id="smoker-on">
                                                    <label for="smoker-on">Yes</label>
                                                    <input type="radio" value="0" name="isASmoker" checked="checked"
                                                           id="smoker-off">
                                                    <label for="smoker-off">No</label>
                                                </div>
                                            </div>
                                            <div class="form-group-attached padding-5" id="smokerQuestion"
                                                 style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Amount per day</label>
                                                            <input type="number"
                                                                   name="smokeAmountPerDay"
                                                                   value="1"
                                                                   class="form-control"
                                                                   placeholder="Amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Since When</label>
                                                            <input type="text"
                                                                   class="form-control datepickerGet"
                                                                   name="smokingSinceWhen"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Are you a drinker?</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="isADrinker" id="drinker-on">
                                                    <label for="drinker-on">Yes</label>
                                                    <input type="radio" value="0" name="isADrinker" checked="checked"
                                                           id="drinker-off">
                                                    <label for="drinker-off">No</label>
                                                </div>
                                            </div>
                                            <div class="form-group-attached padding-5" id="drinkerQuestion"
                                                 style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Amount per day</label>
                                                            <input type="number"
                                                                   value="1"
                                                                   class="form-control"
                                                                   name="drinkAmountPerDay"
                                                                   placeholder="Amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Since When</label>
                                                            <input type="text"
                                                                   class="form-control datepickerGet"
                                                                   name="drinkingSinceWhen"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr/>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Had an Accident</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="hadAnAccident" id="accident-on">
                                                    <label for="accident-on">Yes</label>
                                                    <input type="radio" value="0" name="hadAnAccident" checked="checked"
                                                           id="accident-off">
                                                    <label for="accident-off">No</label>
                                                </div>
                                            </div>

                                            <div class="form-group-attached padding-5" id="accidentQuestion"
                                                 style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default required">
                                                            <label class="label-sm">When</label>
                                                            <input type="text"
                                                                   name="accidentDate"
                                                                   class="form-control datepickerGet"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Type of Accident</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="typeOfAccident"
                                                                   placeholder="Type of Accident">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Surgery</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="hadASurgery" id="operation-on">
                                                    <label for="operation-on">Yes</label>
                                                    <input type="radio" value="0" name="hadASurgery" checked="checked"
                                                           id="operation-off">
                                                    <label for="operation-off">No</label>
                                                </div>
                                            </div>

                                            <div class="form-group-attached padding-5" id="operationQuestion"
                                                 style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">When</label>
                                                            <input type="text"
                                                                   name="surgeryDate"
                                                                   class="form-control datepickerGet"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Type of Surgery</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="typeOfSurgery"
                                                                   placeholder="Type of Surgery">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="">
                                                <p>Hospitalized</p>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="1" name="hasHospitalized"
                                                           id="hospitalized-on">
                                                    <label for="hospitalized-on">Yes</label>
                                                    <input type="radio" value="0" name="hasHospitalized"
                                                           checked="checked" id="hospitalized-off">
                                                    <label for="hospitalized-off">No</label>
                                                </div>
                                            </div>

                                            <div class="form-group-attached padding-5" id="hospitalizedQuestion"
                                                 style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">When</label>
                                                            <input type="text"
                                                                   class="form-control datepickerGet"
                                                                   name="dateHospitalized"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Type of Medication</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="typeOfMedication"
                                                                   placeholder="Type of Medication">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Special Habits</p>

                                            <div class="form-group-attached padding-5" id="accidentQuestion">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Dietary habit</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="dietaryHabit"
                                                                   placeholder="Dietary habit">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Type of sport</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="typeOfSport"
                                                                   placeholder="Type of sport">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Amount per week</label>
                                                            <input type="number"
                                                                   class="form-control"
                                                                   name="sportAmountPerWeek"
                                                                   placeholder="Sports routine per week">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Notes etc</label>
                                                            <input placeholder="Notes etc"
                                                                   class="form-control"
                                                                   name="extraNotes">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <p>Physical Information</p>

                                            <div class="form-group padding-5">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default ">
                                                            <label class="label-sm">Body height</label>
                                                            <input type="number" class="form-control"
                                                                   name="bodyHeight"
                                                                   placeholder="Height body">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-mg-12">
                                                        <p>Do you wear glasses</p>
                                                        <div class="radio radio-success">
                                                            <input type="radio" value="1" name="wearGlasses"
                                                                   id="glasses-on">
                                                            <label for="glasses-on">Yes</label>
                                                            <input type="radio" value="0" name="wearGlasses"
                                                                   checked="checked"
                                                                   id="glasses-off">
                                                            <label for="glasses-off">No</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group padding-5" id="glassesQuestion"
                                                             style="display: none;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group form-group-default ">
                                                                        <label class="label-sm">Glasses size</label>
                                                                        <input type="text"
                                                                               placeholder="e.g. L:-2.0 , R: -1.5"
                                                                               name="glassesSize"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button style="margin-top: 55px;"
                                                                class="btn btn-outline-primary btn-block"
                                                                id="saveMedicalRecordsBtn"
                                                                type="button">Save Employee Medical Records
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>  <!-- End of Medical Records Tab -->

                    <div class="tab-pane slide-left padding-20 sm-no-padding " id="tab-employment">
                        <!-- Start of Employment Tab -->
                        <div class="row row-same-height">
                            <div class="col-md-7 b-r b-dashed b-grey ">
                                <div class="padding-30 sm-padding-5">
                                    {{--<span class="text-primary pointer" id="go-back-to-personal-tab"><i--}}
                                    {{--class="pg-arrow_left"></i>Go Back</span>--}}
                                    <p class="form-title">Employment Information</p>
                                    <form role="form" id="employmentForm">

                                        <div class="form-group-attached">
                                            <div class="form-group form-group-default  required">
                                                <label class="">Job Position</label>
                                                <select class="form-control"
                                                        name="jobPositionId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($jobPositions as $jobPosition)
                                                        <option value="{{$jobPosition->id}}">{{$jobPosition->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default  required">
                                                <label class="">Division</label>
                                                <select class="form-control"
                                                        name="divisionId"
                                                        required
                                                >
                                                    <option value="" disabled selected></option>
                                                    @foreach($divisions as $division)
                                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default  required">
                                                <label class="">Office Branch</label>
                                                <select class="form-control"
                                                        name="branchOfficeId"
                                                        required>
                                                    <option value="" disabled selected></option>
                                                    @foreach($branchOffices as $branchOffice)
                                                        <option value="{{$branchOffice->id}}">{{$branchOffice->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group form-group-default  required">
                                                <label class="">Recruitment Status</label>
                                                <select class="form-control"
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
                    </div> <!-- End of Employment Tab -->
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection