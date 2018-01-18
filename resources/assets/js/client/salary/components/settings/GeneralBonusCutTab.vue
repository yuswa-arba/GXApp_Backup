<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-hover bonusCutDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black" style="width: 80px">ID</th>
                                        <th class="text-black">Bonus Cut Type</th>
                                        <th class="text-black">Value</th>
                                        <th class="text-black">With Formula</th>
                                        <th class="text-black">Active</th>
                                        <th class="text-black" style="width:150px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(generalBC,index) in generalBCs">
                                        <td>{{generalBC.id}}</td>
                                        <td>
                                            {{generalBC.bonusCutTypeName}} ({{generalBC.bonusCutTypeAddOrSub}})
                                        </td>

                                        <td>
                                            <span class="fs-14" v-if="generalBC.value">{{generalBC.value}}</span>
                                            <span v-else="">-</span>
                                        </td>

                                        <td>
                                            <span v-if="generalBC.isUsingFormula && generalBC.formula">  {{generalBC.formula}}</span>
                                            <span v-else="">-</span>

                                        </td>
                                        <td>
                                            <i class="fa fa-check text-primary fs-16" v-if="generalBC.isActive"></i>
                                            <i class="fa fa-times text-danger fs-16" v-else=""></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-pencil fs-16 cursor"
                                               @click="attempEditGeneralBonusCut(generalBC.id)"></i>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <label for="" class="help pull-right m-t-10" style="opacity: 0.7">Scroll for more</label>
                </div>
            </div>
        </div>

        <div class="col-lg-4 m-b-10">
            <div class="card card-transparent">
                <div class="card-block">
                    <form id="bonus-cut-form">
                        <h4>Apply Bonus Cut</h4>
                        <div>
                            <div class="row clearfix">
                                <div class="col-md-9">
                                    <div class="form-group required">
                                        <select name="" id="" class="form-control" v-model="bonusCutTypeIdToUse">
                                            <option value="" disabled hidden selected>Select Bonus Cut</option>
                                            <option :value="bonuscut.id" v-for="bonuscut in bonuscuts">{{bonuscut.name}}
                                                ({{bonuscut.addOrSub}})
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <button class="btn btn-primary fs-16" type="button"
                                                @click="createGeneralBonusCut()">Use
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <p>Bonus cut can only be use once, but you may edit it later</p>

                    </form>

                </div>
            </div>
        </div>


        <!-- Start modal -->
        <div class="modal fade stick-up" id="modal-edit-general-bonus-cut" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-role"></div>-->
                        <h5 class="text-left dark-title p-b-5">Edit General Bonus Cut</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Bonus Cut Type Name</label>
                                        <br>
                                        <span class="fs-16 bold">
                                              {{editGeneralBonusCutForm.bonusCutTypeName}} <span class="text-primary">({{editGeneralBonusCutForm.bonusCutTypeAddOrSub}})</span>
                                        </span>

                                    </div>
                                    <div class="checkbox check-success  ">
                                        <input type="checkbox" :value="1" id="using-formula-cb"
                                               v-model="editGeneralBonusCutForm.isUsingFormula">
                                        <label for="using-formula-cb" class="fs-16">With Formula</label>
                                    </div>

                                    <div class="form-group" v-if="editGeneralBonusCutForm.isUsingFormula">
                                        <label>Formula</label>
                                        <br>
                                        <label class="label label-default fs-12 cursor" @click="insertSalaryOperator()">insert <b class="text-true-black">_salary_</b></label>
                                        <p>Available operators : <span class="bold fs-16">/ , * , + , - , ( , )</span></p>

                                        <input type="text" class="form-control"
                                               style="height: 55px"
                                               placeholder="e.g: _salary_/25*8/60"
                                               v-model="editGeneralBonusCutForm.formula">
                                        <p class="text-danger">Make sure to insert a valid format in order for the formula to work, system is case sensitive</p>
                                        <p class="text-danger">Please note that this should returns value that will then be "added/subtracted" to/from the salary based on the Bonus Cut type</p>
                                        <br>

                                    </div>

                                    <div class="form-group" v-if="!editGeneralBonusCutForm.isUsingFormula">
                                        <label for="">Value</label>
                                        <input type="text" class="form-control" v-model="editGeneralBonusCutForm.value">
                                    </div>

                                    <div class="checkbox check-success ">
                                        <input type="checkbox" :value="1" id="active-cb"
                                               v-model="editGeneralBonusCutForm.isActive">
                                        <label for="active-cb" class="fs-16">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 m-t-10 sm-m-t-10">
                                    <button type="button" class="btn btn-primary btn-block m-t-5" @click="doneEditingGeneralBonusCut()">
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
        <!-- /.modal-dialog -->


    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                generalBCs: [],
                bonuscuts: [],
                bonusCutTypeIdToUse: '',
                editGeneralBonusCutForm: {
                    generalBonusCutId: '',
                    bonusCutTypeName: '',
                    value: '',
                    isActive: 0,
                    isUsingFormula: 0,
                    formula: ''
                },
                formIsValid: false
            }
        },
        created(){
            let self = this

            // get bonus cut data
            get(api_path + 'salary/generalBC/bonuscut/list')
                .then((res) => {
                    self.bonuscuts = res.data.bonuscut.data
                })

            // get general bonus cut data
            get(api_path + 'salary/generalBC/list')
                .then((res) => {
                    self.generalBCs = res.data.generalBC.data
                })


        },
        methods: {
            createGeneralBonusCut(){
                let self = this
                if (self.bonusCutTypeIdToUse) {

                    post(api_path + 'salary/generalBC/create', {bonusCutTypeId: self.bonusCutTypeIdToUse})
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
                                self.generalBCs.push(res.data.generalBC.data)

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
                        message: 'Bonus cut cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            attempEditGeneralBonusCut(generalBonusCutId){

                let self = this
                let generalBonusCut = _.find(self.generalBCs, {id: generalBonusCutId})

                // Insert to form
                self.editGeneralBonusCutForm.generalBonusCutId = generalBonusCutId
                self.editGeneralBonusCutForm.bonusCutTypeName = generalBonusCut.bonusCutTypeName
                self.editGeneralBonusCutForm.bonusCutTypeAddOrSub = generalBonusCut.bonusCutTypeAddOrSub
                self.editGeneralBonusCutForm.value = generalBonusCut.value
                self.editGeneralBonusCutForm.isActive = generalBonusCut.isActive
                self.editGeneralBonusCutForm.isUsingFormula = generalBonusCut.isUsingFormula
                self.editGeneralBonusCutForm.formula = generalBonusCut.formula

                $('#modal-edit-general-bonus-cut').modal('show')
            },
            doneEditingGeneralBonusCut(){

                let self = this
                if (self.formIsValid) {

                    // remove from object before submit bcs its not needed
                    delete self.editGeneralBonusCutForm.bonusCutTypeName
                    delete self.editGeneralBonusCutForm.addOrSub

                    post(api_path + 'salary/generalBC/edit', self.editGeneralBonusCutForm)
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
                                if(res.data.generalBC.data){
                                    let generalBonusCutIndex = _.findIndex(self.generalBCs,{id:self.editGeneralBonusCutForm.generalBonusCutId})
                                    self.generalBCs.splice(generalBonusCutIndex,1,res.data.generalBC.data)
                                }

                                /* Close modal */
                                $('#modal-edit-general-bonus-cut').modal('toggle')


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

                    if (self.editGeneralBonusCutForm.isUsingFormula && self.editGeneralBonusCutForm.formula) { /* If using formula, formula is required*/

                        self.formIsValid = true
                        self.doneEditingGeneralBonusCut()

                    } else if (!self.editGeneralBonusCutForm.isUsingFormula && self.editGeneralBonusCutForm.value) { /* If not using formula , value is required */

                        self.formIsValid = true
                        self.doneEditingGeneralBonusCut()

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
                self.editGeneralBonusCutForm.formula = self.editGeneralBonusCutForm.formula + '_salary_'
            }


        },
        computed: {}

    }
</script>