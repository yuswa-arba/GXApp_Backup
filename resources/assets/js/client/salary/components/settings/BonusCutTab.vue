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
                                        <th class="text-black" style="width: 100px">ID</th>
                                        <th class="text-black" style="width: 300px;">Name</th>
                                        <th class="text-black">Add/Sub</th>
                                        <th class="text-black">Division Related</th>
                                        <th class="text-black" style="width:150px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(bonuscut,index) in bonuscuts">
                                        <td>{{bonuscut.id}}</td>
                                        <td>
                                            <span class="fs-14" v-if="!bonuscut.editing">{{bonuscut.name}}</span>
                                            <input v-else="" type="text" :name="'bonusCutName_'+bonuscut.id"
                                                   :value="bonuscut.name">
                                        </td>
                                        <td>
                                            <label v-if="bonuscut.addOrSub=='add'" class="label label-success fs-14">{{bonuscut.addOrSub}}</label>
                                            <label v-else-if="bonuscut.addOrSub=='sub'"
                                                   class="label label-danger fs-14">{{bonuscut.addOrSub}}</label>
                                            <label v-else=""></label>
                                        </td>
                                        <td>
                                            <span v-if="bonuscut.isRelatedToDivision">  {{bonuscut.divisionName}}</span>
                                            <span v-else="">-</span>
                                        </td>
                                        <td>
                                            <i v-if="!bonuscut.editing" class="fa fa-pencil fs-16 cursor"
                                               @click="editBonusCutType(index)"></i>
                                            <span v-else="" class="fs-12 text-primary cursor"
                                                  @click="doneEditing(bonuscut.id,index)">DONE</span>
                                            &nbsp;&nbsp;
                                            <i class="fa fa-times text-danger fs-16 cursor"
                                               @click="deleteBonusCutType(bonuscut.id,index)"></i>
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
                        <h4>Bonus Cut Form</h4>
                        <div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Name</label>
                                        <input id="name" type="text" v-model="bonusCutForm.name" class="form-control"
                                               name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Add / Sub</label>
                                        <select name="" id="" class="form-control" v-model="bonusCutForm.addOrSub">
                                            <option value="add">Add</option>
                                            <option value="sub">Sub</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="checkbox check-success  ">
                                        <input type="checkbox" :value="1" v-model="bonusCutForm.isRelatedToDivision"
                                               id="related-to-division">
                                        <label for="related-to-division">Related to Division</label>
                                    </div>
                                </div>
                                <div class="col-md-12" v-if="bonusCutForm.isRelatedToDivision">
                                    <div class="form-group required">
                                        <label>Division</label>
                                        <select name="" class="form-control" v-model="bonusCutForm.divisionId">
                                            <option value="" disabled hidden selected>Select Division</option>
                                            <option :value="division.id" v-for="division in divisions">
                                                {{division.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <p>If bonus/cut is related to division, it can only be given to employee within that
                            division</p>
                        <button class="btn btn-complete pull-right" type="button" @click="saveBonusCutForm()">Save
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                divisions: [],
                bonuscuts: [],
                bonusCutForm: {
                    name: '',
                    addOrSub: 'add',
                    isRelatedToDivision: 0,
                    divisionId: '',
                },
                formIsValid: false
            }
        },
        created(){
            let self = this

            // get division data
            get(api_path + 'component/list/divisions')
                .then((res) => {
                    self.divisions = res.data.data
                })

            // get bonus cut tab data
            get(api_path + 'salary/bonuscut/list')
                .then((res) => {
                    self.bonuscuts = res.data.bonuscut.data
                })


        },
        methods: {
            saveBonusCutForm(){

                let self = this

                if (self.formIsValid) {
                    post(api_path + 'salary/bonuscut/create', self.bonusCutForm)
                        .then((res) => {
                            self.formIsValid = false

                            if (!res.data.isFailed) {

                                /* Success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                self.bonuscuts.push(res.data.bonuscut.data)

                                //reset form
                                self.bonusCutForm = {
                                    name: '',
                                    addOrSub: 'add',
                                    isRelatedToDivision: false,
                                    divisionId: '',
                                }


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

                            self.formIsValid = false

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
                    if (self.bonusCutForm.name && self.bonusCutForm.addOrSub) {
                        if (self.bonusCutForm.isRelatedToDivision) {
                            if (self.bonusCutForm.divisionId) {

                                self.formIsValid = true
                                self.saveBonusCutForm()

                            } else {

                                self.formIsValid = false

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'Division cannot be empty',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();

                            }
                        } else {

                            self.formIsValid = true
                            self.saveBonusCutForm()
                        }

                    } else {

                        self.formIsValid = false

                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: 'Name and add/sub cannot be empty',
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();

                    }
                }
            },

            deleteBonusCutType(bonusCutTypeId, bonusCutTypeIndex){
                let self = this
                if (confirm('Are you sure to delete this?')) {
                    post(api_path + 'salary/bonuscut/delete', {bonusCutTypeId: bonusCutTypeId})
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

                                /* remove from array */
                                self.bonuscuts.splice(bonusCutTypeIndex, 1)

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
            },
            editBonusCutType(bonusCutTypeIndex){
                let self = this
                self.bonuscuts[bonusCutTypeIndex].editing = true
            },
            doneEditing(bonusCutTypeId, bonusCutTypeIndex){
                let self = this

                let oldBonusCutName = self.bonuscuts[bonusCutTypeIndex].name
                let bonusCutName = $('input[name="' + 'bonusCutName_' + bonusCutTypeId + '"]').val()

                if (bonusCutName != oldBonusCutName) { // if its different then submit to server
                    if (bonusCutTypeId && bonusCutName) {

                        post(api_path + 'salary/bonuscut/edit', {
                            bonusCutTypeId: bonusCutTypeId,
                            bonusCutName: bonusCutName
                        })
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    /* Succeess notification */
                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    /*Change name*/
                                    self.bonuscuts[bonusCutTypeIndex].name = bonusCutName

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


                self.bonuscuts[bonusCutTypeIndex].editing = false
            }

        },
        computed: {}
    }
</script>