<template>
    <div class="row">
        <div class="col-lg-4 m-b-10">
            <div class="card no-border">
                <div class="card-block">
                    <form id="manager-form">
                        <h4>Manager Form</h4>

                        <div class="row clearfix">
                            <div class="col-lg-12" v-if="!selectedEmployee.employeeId"> <!-- search employee -->
                                <div class="row">
                                    <div class="col-lg-12 m-b-10">
                                        <div class="input-group">
                                            <input type="text" style="height: 40px;" class="form-control"
                                                   @keyup.enter="searchEmployee()"
                                                   placeholder="Search Employee Number / Name / Surname / Nickname"
                                                   v-model="searchText"
                                            >
                                            <span class="input-group-addon primary" @click="searchEmployee()"><i
                                                    class="fa fa-search cursor"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" v-if="employeeCandidates.length>0">
                                        <label class="p-t-10"> Choose employee</label>
                                        <div class="scrollable">
                                            <div style="height: 300px">
                                                <div class="d-flex-not-important flex-column p-t-0 filter-employee"
                                                     v-for="candidate in employeeCandidates">
                                                    <div class="card social-card share  full-width m-b-0 d-flex flex-1 full-height no-border sm-vh-75"
                                                         data-social="item"
                                                         @click="pickEmployee(candidate.id,candidate.employeeNo,candidate.givenName,candidate.surname)">

                                                        <div class="card-header clearfix">
                                                            <h5 style="float: right"><span
                                                                    style="font-weight: normal!important"
                                                                    class="fs-14">({{candidate.employeeNo}})</span>
                                                            </h5>

                                                            <div class="user-pic">
                                                                <img alt="None"
                                                                     :src="`/images/employee/${candidate.employeePhoto}`"
                                                                     width="38" height="38"
                                                                />
                                                            </div>
                                                            <h5 class="fs-18">{{candidate.givenName}} </h5>
                                                            <h6 class="fs-14" style="opacity: .7">
                                                                {{candidate.surname}}</h6>
                                                            <h6 class="text-primary" style="margin-top: 3px">
                                                                {{candidate.jobPosition}}</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" v-else="">  <!--selected employee-->
                                <div class="form-group" readonly="">
                                    <label> Employee </label>
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control text-true-black bold"
                                               :value="selectedEmployee.givenName+' '+selectedEmployee.surname +' ('+ selectedEmployee.employeeNo +') '">
                                        <span class="input-group-addon danger" @click="removeSelectedEmployee()"><i
                                                class="fa fa-times cursor"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group  required">
                                    <label>Division</label>
                                    <div class="form-group required">
                                        <select v-model="formObject.divisionId" class="form-control">
                                            <option value="" disabled hidden>Select Division</option>
                                            <option :value="division.id" v-for="division in divisions">
                                                {{division.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="form-group  required">
                                    <label>Branch Office</label>
                                    <div class="form-group required">
                                        <select v-model="formObject.branchOfficeId" class="form-control">
                                            <option value="" disabled hidden>Select Branch Office</option>
                                            <option :value="branchOffice.id" v-for="branchOffice in branchOffices">
                                                {{branchOffice.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-complete pull-right" type="button"
                                        @click="assignDivisionManager()">
                                    Assign
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">Division (Branch)</th>
                                        <th class="text-black">Active</th>
                                        <th class="text-black">Start Date</th>
                                        <th class="text-black">End Date</th>
                                        <th class="text-black" style="width:250px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="manager in managers" class="filter-item">
                                        <td>{{manager.employeeName}} ({{manager.employeeNo}})</td>
                                        <td>{{manager.divisionName}} ({{manager.branchOfficeName}})</td>
                                        <td>
                                            <i class="fa fa-times text-danger" v-if="!manager.isActive"></i>
                                            <i class="fa fa-check text-success" v-else=""></i>
                                        </td>
                                        <td>
                                            <span v-if="manager.startDate!=''">{{manager.startDate}}</span>
                                            <span v-else="">-</span>
                                        </td>
                                        <td>
                                            <span v-if="manager.endDate!=''">{{manager.endDate}}</span>
                                            <span v-else="">-</span>
                                        </td>
                                        <td>
                                            <button class="btn"
                                                    :disabled="manager.isActive==1"
                                                    :class="{'btn-primary':!manager.isActive,'btn-disabled':manager.isActive}"
                                                    @click="activateManager(manager.id)">Activate
                                            </button>
                                            <button class="btn"
                                                    :disabled="manager.isActive==0"
                                                    :class="{'btn-danger':manager.isActive,'btn-disabled':!manager.isActive}"
                                                    @click="deactivateManager(manager.id)">Deactivate
                                            </button>
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
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                searchText: '',
                selectedEmployee: {
                    employeeId: '', employeeNo: '', givenName: '', surname: ''
                },
                formObject: {
                    employeeId: '',
                    divisionId: '',
                    branchOfficeId:''
                }
            }
        },
        created(){
            let self = this
            this.$store.dispatch('managers/getDataOnCreate')
            this.$store.state.managers.employeeCandidates = [] //reset the first time

        },
        computed: {
            ...mapState('managers', {
                divisions: 'divisions',
                branchOffices:'branchOffices',
                managers: 'managers',
                employeeCandidates: 'employeeCandidates'
            })
        },
        methods: {
            assignDivisionManager(){
                let self = this

                if (self.formObject.employeeId != '' && self.formObject.divisionId != '' && self.formObject.branchOfficeId!='') {

                    //assign
                    this.$store.commit({
                        type: 'managers/assignManager',
                        formObject: self.formObject
                    })



                    //refresh
                    setTimeout(() => {
                        this.$store.commit({type: 'managers/getManagers'})

                        //reset
                        this.removeSelectedEmployee()
                        self.formObject = {
                            employeeId: '',
                            divisionId: '',
                            branchOfficeId:''
                        }
                    }, 1200)

                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Form is invalid',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            },
            searchEmployee(){

                let self = this

                this.$store.commit({
                    type: 'managers/searchEmployee',
                    searchText: self.searchText
                })

            },
            pickEmployee(candidateId, candidateNo, candidateGivenName, candidateSurname){
                let self = this

                self.selectedEmployee.employeeId = candidateId
                self.selectedEmployee.employeeNo = candidateNo
                self.selectedEmployee.givenName = candidateGivenName
                self.selectedEmployee.surname = candidateSurname

                self.formObject.employeeId = candidateId //insert to form object

            },
            removeSelectedEmployee(){
                let self = this

                this.$store.state.managers.employeeCandidates = [] //reset the first time
                self.searchText = ''

                self.selectedEmployee.employeeId = ''

                self.selectedEmployee.employeeNo = ''
                self.selectedEmployee.givenName = ''
                self.selectedEmployee.surname = ''

                self.formObject.employeeId = '' //remove from form object

            },
            activateManager(divisionManagerId){
                this.$store.commit({
                    type: 'managers/activateManager',
                    divisionManagerId: divisionManagerId
                })

                //refresh
                setTimeout(() => {
                    this.$store.commit({type: 'managers/getManagers'})
                }, 1200)

            },
            deactivateManager(divisionManagerId){
                this.$store.commit({
                    type: 'managers/deactivateManager',
                    divisionManagerId: divisionManagerId
                })

                //refresh
                setTimeout(() => {
                    this.$store.commit({type: 'managers/getManagers'})
                }, 1200)

            }
        },

    }
</script>