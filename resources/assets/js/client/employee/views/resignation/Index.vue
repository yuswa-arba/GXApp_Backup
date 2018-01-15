<template>
    <div class="row row-same-height">
        <div class="col-lg-6">

            <div class="card card-default">
                <div class="card-header ">
                    <div class="card-title">Search Employee</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" style="height: 40px;" class="form-control" id="search-employee-box"
                                       placeholder="Search Employee Number / Name / Surname / Nickname"
                                       v-model="searchText"
                                >
                                <span class="input-group-addon primary" @click="searchEmployee()"><i
                                        class="fa fa-search cursor"></i></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="p-t-10" v-if="candidates.length>0"> Choose employee</label>

                            <div class="d-flex-not-important flex-column p-t-0 filter-employee"
                                 v-for="candidate in candidates">
                                <div class="card social-card share  full-width m-b-0 d-flex flex-1 full-height no-border sm-vh-75"
                                     data-social="item"
                                     @click="pickEmployee(candidate.id,candidate.employeeNo,candidate.givenName,candidate.surname)">

                                    <div class="card-header clearfix">
                                        <h5 style="float: right"><span style="font-weight: normal!important"
                                                                       class="fs-14">({{candidate.employeeNo}})</span>
                                        </h5>

                                        <div class="user-pic">
                                            <img alt="None"
                                                 :src="`/images/employee/${candidate.employeePhoto}`"
                                                 width="38" height="38"
                                            />
                                        </div>
                                        <h5 class="fs-18">{{candidate.givenName}} </h5>
                                        <h6 class="fs-14" style="opacity: .7">{{candidate.surname}}</h6>
                                        <h6 class="text-primary" style="margin-top: 3px">{{candidate.jobPosition}}</h6>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title"> Resignation Form</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group form-group-default required">
                                <label style="opacity: 1!important;"> Employee <span
                                        class="help fs-10">(Choose employee from search table)</span></label>
                                <input type="text" readonly class="form-control" v-if="!employeePicked">
                                <input v-else="" type="text" readonly class="form-control text-true-black bold"
                                       :value="employeeData.givenName+' '+employeeData.surname +' ('+ employeeData.employeeNo +') '">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group form-group-default required">
                                <label> Professionalism </label>
                                <select class="form-control" v-model="formObject.professionalism">
                                    <option value="professional">Professional</option>
                                    <option value="unprofessional">Unprofessional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6"
                             :class="{hide:formObject.professionalism=='unprofessional'}">

                            <div class="form-group form-group-default required">
                                <label>Submission Date</label>
                                <input type="text"
                                       id="submissionDate"
                                       class="form-control datepicker"
                                       required>
                            </div>
                        </div>
                        <div :class="{'col-lg-12':formObject.professionalism=='unprofessional','col-lg-6':formObject.professionalism=='professional'}"
                             class="col-lg-6">
                            <div class="form-group form-group-default required">
                                <label>Effective Resignation Date</label>
                                <input type="text"
                                       id="effectiveDate"
                                       class="form-control datepicker"
                                       required>
                            </div>
                        </div>
                        <div class="col-lg-12" :class="{hide:formObject.professionalism=='unprofessional'}">
                            <div class="form-group form-group-default required">
                                <label> Resignation Letter </label>
                                <input id="resignationLetter"
                                       type="file"
                                       @change="insertLetterToForm($event)"
                                       name="resignationLetter"
                                       accept="image/*"
                                       required/>
                            </div>
                        </div>
                        <div class="col-lg-12" :class="{hide:formObject.professionalism=='unprofessional'}">
                            <div class="form-group form-group-default required">
                                <label> Reason of Resignation </label>
                                <input type="text"
                                       v-model="formObject.reason"
                                       class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="col-lg-12" :class="{hide:formObject.professionalism!='unprofessional'}">
                            <div class="form-group form-group-default required">
                                <label> Notes </label>
                                <input type="text"
                                       v-model="formObject.notes"
                                       class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="pull-right btn btn-primary"
                                    @click="saveResignation()"
                                    :disabled="disableSaveBtn"
                            >Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {objectToFormData} from '../../../helpers/utils'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                searchText: '',
                disableSaveBtn: true,
                candidates: [],
                employeeData: {
                    employeeId: '',
                    employeeNo: '',
                    givenName: '',
                    surname: ''
                },
                employeePicked: false,
                formObject: {
                    employeeId: '',
                    submissionDate: '',
                    effectiveDate: '',
                    resignationLetter: {},
                    reason: '',
                    professionalism: 'professional',
                    notes: ''
                }
            }
        },
        methods: {
            searchEmployee(){

                let self = this
                if (self.searchText) {
                    get(api_path + 'employee/search/' + self.searchText)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.candidates.data) {
                                    self.candidates = res.data.candidates.data
                                }
                            } else {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            }
                        })
                        .catch((err) => {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: "Search box cannot be empty",
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }


            },
            pickEmployee(candidateId, candidateNo, candidateGivenName, candidateSurname){
                let self = this

                self.employeeData.employeeId = candidateId
                self.employeeData.employeeNo = candidateNo
                self.employeeData.givenName = candidateGivenName
                self.employeeData.surname = candidateSurname

                self.employeePicked = true
                self.disableSaveBtn = false

                self.formObject.employeeId = self.employeeData.employeeId
            },
            insertLetterToForm(e){
                let self = this
                self.formObject.resignationLetter = e.target.files[0]
            },

            saveResignation(){
                let self = this

                self.formObject.submissionDate = $('#submissionDate').val()
                self.formObject.effectiveDate = $('#effectiveDate').val()

                if (self.formObject.employeeId
                    && self.formObject.submissionDate
                    && self.formObject.effectiveDate
                    && self.formObject.resignationLetter
                    && self.formObject.reason
                    && self.formObject.professionalism
                ) {
                    post(api_path + 'employee/resignation', objectToFormData(self.formObject))
                        .then((res) => {

                            if (!res.data.isFailed) {

                            } else {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            }

                        })
                        .catch((err) => {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })

                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: "Form has to be completed",
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            }

        },
        mounted(){

        }
    }
</script>