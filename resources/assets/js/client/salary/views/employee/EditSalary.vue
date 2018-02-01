<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <button class="btn btn-outline-primary m-r-15 m-b-10 pull-left"
                    @click="done()"><i class="fa fa-check"></i>
                Done
            </button>


        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee ID</label>
                            <p class="text-primary">{{$route.params.id}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{employeeDetail.employeeNo}}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employee Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4">
                            <div style="" class="cursor">
                                <img :src="`/images/employee/${employeeDetail.employeePhoto}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-4 employee-details">

                            <label>Surname/Given name</label>
                            <h5>{{employeeDetail.surname}}/{{employeeDetail.givenName}}</h5>

                            <label>Email</label>
                            <h5>{{employeeDetail.email}}</h5>

                            <label>Bank Account</label>
                            <h5>{{employeeDetail.bankAccNo}} ({{employeeDetail.bankName}})</h5>


                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Division</label>
                            <h5>{{employeeDetail.divisionName}}</h5>

                            <label>Job Position</label>
                            <h5>{{employeeDetail.jobPositionName}}</h5>

                            <label>Branch Office</label>
                            <h5>{{employeeDetail.branchOfficeName}}</h5>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Salary Information</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details m-b-10">
                            <label>Basic Salary</label>
                            <input min="0" type="number" class="form-control" v-model="editSalaryForm.basicSalary">
                        </div>

                        <div class="col-lg-6">
                            <button class="btn btn-complete pull-left m-t-20"
                                    @click="saveSalary()">
                                Save
                            </button>
                        </div>


                    </div>
                </div>
            </div>
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Bonus/Cut</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-transparent">
                                <div class="card-block">
                                    <form id="bonus-cut-form">
                                        <h4>Apply Bonus/Cut</h4>
                                        <div>
                                            <div class="row clearfix">
                                                <div class="col-md-9">
                                                    <div class="form-group required">
                                                        <select name="" id="" class="form-control"
                                                                v-model="bonusCutTypeIdToUse">
                                                            <option value="" disabled hidden selected>Select Bonus/Cut
                                                            </option>
                                                            <option :value="bonuscut.id" v-for="bonuscut in bonuscuts">
                                                                {{bonuscut.name}}
                                                                ({{bonuscut.addOrSub}})
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for=""></label>
                                                        <button class="btn btn-primary fs-16" type="button"
                                                                @click="useBonusCut()">Use
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <p>Bonus/cut can only be use once, but you may edit it later</p>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-block no-padding">
                                    <div class="scrollable">
                                        <div style="height: 400px;">
                                            <div class="table-responsive">
                                                <table class="table table-hover employeeBonusCutDT">
                                                    <thead class="bg-master-lighter">
                                                    <tr>
                                                        <th class="text-black padding-10" style="width: 50px">ID</th>
                                                        <th class="text-black padding-10" style="width:210px;">Bonus/Cut
                                                            Type
                                                        </th>
                                                        <th class="text-black padding-10">Value</th>
                                                        <th class="text-black padding-10">With Formula</th>
                                                        <th class="text-black padding-10">Active</th>
                                                        <th class="text-black padding-10">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(bonusCutDetail,index) in bonusCutDetails">
                                                        <td>{{bonusCutDetail.id}}</td>
                                                        <td>
                                                            {{bonusCutDetail.bonusCutTypeName}}
                                                            <label v-if="bonusCutDetail.bonusCutTypeAddOrSub=='add'"
                                                                   class="label label-success fs-14">{{bonusCutDetail.bonusCutTypeAddOrSub}}</label>
                                                            <label v-else-if="bonusCutDetail.bonusCutTypeAddOrSub=='sub'"
                                                                   class="label label-danger fs-14">{{bonusCutDetail.bonusCutTypeAddOrSub}}</label>
                                                            <label v-else=""></label>
                                                        </td>

                                                        <td>
                                                            <span class="fs-14" v-if="bonusCutDetail.value">{{bonusCutDetail.value}}</span>
                                                            <span v-else="">-</span>
                                                        </td>

                                                        <td>
                                                            <span v-if="bonusCutDetail.isUsingFormula && bonusCutDetail.formula">  {{bonusCutDetail.formula}}</span>
                                                            <span v-else="">-</span>

                                                        </td>
                                                        <td>
                                                            <i class="fa fa-check text-primary fs-16"
                                                               v-if="bonusCutDetail.isActive"></i>
                                                            <i class="fa fa-times text-danger fs-16" v-else=""></i>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-pencil fs-16 cursor"
                                                               @click="attemptEditBonusCutType(bonusCutDetail.id)"></i>
                                                            &nbsp;
                                                            <i class="fa fa-trash fs-16 text-danger cursor"
                                                               @click="removeBonusCutType(bonusCutDetail.id,index)"></i>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Start modal-->
        <div class="modal fade stick-up" id="modal-edit-bonus-cut" tabindex="-10" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-role"></div>-->
                        <h5 class="text-left dark-title p-b-5">Edit Bonus/Cut</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Bonus/Cut Type Name</label>
                                        <br>
                                        <span class="fs-16 bold">
                                              {{editBonusCutForm.bonusCutTypeName}} <span class="text-primary">({{editBonusCutForm.bonusCutTypeAddOrSub}})</span>
                                        </span>

                                    </div>
                                    <div class="checkbox check-success  ">
                                        <input type="checkbox" :value="1" id="using-formula-cb"
                                               v-model="editBonusCutForm.isUsingFormula">
                                        <label for="using-formula-cb" class="fs-16">With Formula</label>
                                    </div>

                                    <div class="form-group" v-if="editBonusCutForm.isUsingFormula">
                                        <label>Formula</label>
                                        <br>
                                        <label class="label label-default fs-12 cursor" @click="insertSalaryOperator()">insert
                                            <b class="text-true-black">_salary_</b></label>
                                        <p>Available operators : <span class="bold fs-16">/ , * , + , - , ( , )</span>
                                        </p>

                                        <input type="text" class="form-control"
                                               style="height: 55px"
                                               placeholder="e.g: _salary_/25*8/60"
                                               v-model="editBonusCutForm.formula">
                                        <p class="text-danger">Make sure to insert a valid format in order for the
                                            formula to work, system is case sensitive</p>
                                        <p class="text-danger">Please note that this should returns value that will then
                                            be "added/subtracted" to/from the salary based on the Bonus/Cut type</p>
                                        <br>

                                    </div>

                                    <div class="form-group" v-if="!editBonusCutForm.isUsingFormula">
                                        <label for="">Value</label>
                                        <input type="text" class="form-control" v-model="editBonusCutForm.value">
                                    </div>

                                    <div class="checkbox check-success ">
                                        <input type="checkbox" :value="1" id="active-cb"
                                               v-model="editBonusCutForm.isActive">
                                        <label for="active-cb" class="fs-16">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 m-t-10 sm-m-t-10">
                                    <button type="button" class="btn btn-primary btn-block m-t-5"
                                            @click="saveEditBonusCut()">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                employeeDetail: [],
                salaryDetail: [],
                bonusCutDetails: [],
                editSalaryForm: {
                    basicSalary: ''
                },
                bonuscuts: [],
                bonusCutTypeIdToUse: '',
                editBonusCutForm: {
                    bonusCutId: '',
                    bonusCutTypeName: '',
                    value: '',
                    isActive: 0,
                    isUsingFormula: 0,
                    formula: ''
                },
                editBonusCutFormIsValid: false
            }
        },
        created(){
            let self = this

            // get employee salary detail
            get(api_path + 'salary/employee/detail/' + self.$route.params.id)
                .then((res) => {
                    self.employeeDetail = res.data.employee.data
                    self.salaryDetail = res.data.salary.data
                    self.bonusCutDetails = res.data.bonusCut.data

                    self.editSalaryForm.basicSalary = self.salaryDetail.basicSalaryNoFormat
                })

            // get bonus cut data
            get(api_path + 'salary/employee/availableBC/list/' + self.$route.params.id)
                .then((res) => {
                    self.bonuscuts = res.data.bonuscut.data
                })
        },
        methods: {
            done(){
                //return back to detail
                let self = this
                this.$router.push({name: 'detailSalary', params: {id: self.$route.params.id}})
            },
            saveSalary(){
                let self = this
                if (self.editSalaryForm.basicSalary) {

                    post(api_path + 'salary/employee/save/basicSalary/' + self.$route.params.id, {basicSalary: self.editSalaryForm.basicSalary})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                /* Success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                            } else {

                                /* Error notification */
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

                            /* Error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })

                } else {
                    /* Error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Salary cannot be empty, insert 0 instead',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            useBonusCut(){
                let self = this
                if (self.bonusCutTypeIdToUse) {

                    post(api_path + 'salary/employee/use/bonusCut/' + self.$route.params.id, {bonusCutTypeId: self.bonusCutTypeIdToUse})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                /* success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                //push to array
                                self.bonusCutDetails.push(res.data.bonusCut.data)

                                //remove from array
                                let bonusCutIndex = _.findIndex(self.bonuscuts, {id: self.bonusCutTypeIdToUse})
                                self.bonuscuts.splice(bonusCutIndex, 1)

                                //reset
                                self.bonusCutTypeIdToUse = ''
                            } else {

                                /* Error notification */
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
                            /* Error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })


                } else {
                    /* Error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Bonus/cut cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            attemptEditBonusCutType(bonusCutId){

                let self = this
                let bonusCutType = _.find(self.bonusCutDetails, {id: bonusCutId})

                //insert to form
                self.editBonusCutForm.bonusCutId = bonusCutId
                self.editBonusCutForm.bonusCutTypeName = bonusCutType.bonusCutTypeName
                self.editBonusCutForm.bonusCutTypeAddOrSub = bonusCutType.bonusCutTypeAddOrSub
                self.editBonusCutForm.value = bonusCutType.value
                self.editBonusCutForm.isActive = bonusCutType.isActive
                self.editBonusCutForm.isUsingFormula = bonusCutType.isUsingFormula
                self.editBonusCutForm.formula = bonusCutType.formula

                $('#modal-edit-bonus-cut').modal('show')
            },
            saveEditBonusCut(){
                let self = this

                if (self.editBonusCutFormIsValid) {

                    // remove from object before submit bcs its not needed
                    delete self.editBonusCutForm.bonusCutTypeName
                    delete self.editBonusCutForm.addOrSub

                    post(api_path + 'salary/employee/save/bonusCut/' + self.$route.params.id, self.editBonusCutForm)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                /* success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                /* Update general BC array*/
                                if (res.data.bonusCut.data) {
                                    let bonusCutIndex = _.findIndex(self.bonusCutDetails, {id: self.editBonusCutForm.bonusCutId})
                                    self.bonusCutDetails.splice(bonusCutIndex, 1, res.data.bonusCut.data)
                                }

                                /* Reset form value */
                                self.editBonusCutForm = {
                                    bonusCutId: '',
                                    bonusCutTypeName: '',
                                    value: '',
                                    isActive: 0,
                                    isUsingFormula: 0,
                                    formula: ''
                                }

                                /* Close modal */
                                $('#modal-edit-bonus-cut').modal('toggle')

                            } else {
                                /* Error notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            }

                            self.editBonusCutFormIsValid = false
                        })
                        .catch((err) => {
                            /* Error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: 'Unable to submit, form is not valid',
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();

                            self.editBonusCutFormIsValid = false
                        })


                } else {


                    if (self.editBonusCutForm.isUsingFormula && self.editBonusCutForm.formula) { /* If using formula, formula is required*/

                        self.editBonusCutFormIsValid = true
                        self.saveEditBonusCut()

                    } else if (!self.editBonusCutForm.isUsingFormula && self.editBonusCutForm.value) { /* If not using formula , value is required */

                        self.editBonusCutFormIsValid = true
                        self.saveEditBonusCut()

                    } else {

                        /* Error notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: 'Unable to submit, form is not valid',
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }
                }

            },
            insertSalaryOperator(){
                let self = this
                if (self.editBonusCutForm.formula) {
                    self.editBonusCutForm.formula = self.editBonusCutForm.formula + '_salary_'
                } else {
                    self.editBonusCutForm.formula = '_salary_'
                }

            },
            removeBonusCutType(bonusCutId,index){
                let self = this
                if(confirm('Are you sure to remove this bonus/cut ?')){
                    post(api_path + 'salary/employee/remove/bonusCut/' + self.$route.params.id,{bonusCutId:bonusCutId})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                /* Success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();


                                //remove from array
                                self.bonusCutDetails.splice(index,1)

                            } else {
                                /* Error notification */
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
                            /* Error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })
                }
            }
        }
    }
</script>