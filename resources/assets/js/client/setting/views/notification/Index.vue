<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">Add Notification Recipient</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12" v-if="!selectedEmployee.employeeId"> <!-- search employee -->
                            <div class="row">
                                <div class="col-lg-12 m-b-10">
                                    <div class="input-group">
                                        <input type="text" style="height: 40px;" class="form-control"
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
                                                        <h6 class="fs-14" style="opacity: .7">{{candidate.surname}}</h6>
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
                            <div class="form-group form-group-default required">
                                <label> Group Type </label>
                                <select class="form-control" v-model="recipientForm.groupTypeId">
                                    <option value="" disabled hidden selected>Select Group Type</option>
                                    <option v-if="groupType.id!=1" :value="groupType.id"
                                            v-for="groupType in notificationGroupTypes">
                                        {{groupType.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="pull-right btn btn-primary"
                                    @click="addRecipient()"
                                    :disabled="disableSubmitBtn"
                            >Add Recipient
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">Add Group Type</div>
                </div>
                <div class="card-block">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Name </label>
                                <input type="text" class="form-control" v-model="groupTypeForm.name">
                            </div>
                            <p class="help">*To be use by developer </p>
                            <button class="btn btn-primary pull-right" @click="createGroupType()">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 m-b-10">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title">Recipients</div>
                    <div class="pull-right">
                        Sort By:
                        <select v-model="sortGroupTypeId" @change="sortRecipients()">
                            <option value="">All</option>
                            <option v-if="groupType.id!=1" :value="groupType.id"  v-for="groupType in notificationGroupTypes">{{groupType.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Group Type</th>
                                            <th class="text-black">Action</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(recipient,index) in notificationRecipients">
                                            <td>{{recipient.employeeName}}</td>
                                            <td>{{recipient.groupTypeName}}</td>
                                            <td><i class="fa fa-times text-danger fs-16 cursor"
                                                   @click="removeRecipient(recipient.id,index)"></i></td>
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
</template>
<script type="text/javascript">
    import{mapState, mapGetters} from 'vuex'

    export default{
        data(){
            return {
                searchText: '',
                disableSubmitBtn: true,
                selectedEmployee: {
                    employeeId: '', employeeNo: '', givenName: '', surname: ''
                },
                recipientForm: {
                    employeeId: '',
                    groupTypeId: ''
                },
                groupTypeForm: {
                    name: ''
                },
                sortGroupTypeId:''
            }
        },
        computed: {
            ...mapState('notification', {
                employeeCandidates: 'employeeCandidates',
                notificationGroupTypes: 'notificationGroupTypes',
                notificationRecipients: 'notificationRecipients'
            })
        },
        mounted(){

        },
        created(){
            this.$store.dispatch('notification/getDataOnCreate')
            this.$store.state.notification.employeeCandidates = [] //reset the first time
        },
        methods: {
            searchEmployee(){

                let self = this

                this.$store.commit({
                    type: 'notification/searchEmployee',
                    searchText: self.searchText
                })

            },
            pickEmployee(candidateId, candidateNo, candidateGivenName, candidateSurname){
                let self = this

                self.selectedEmployee.employeeId = candidateId
                self.selectedEmployee.employeeNo = candidateNo
                self.selectedEmployee.givenName = candidateGivenName
                self.selectedEmployee.surname = candidateSurname

                self.recipientForm.employeeId = candidateId //insert to form object

                self.disableSubmitBtn = false

            },
            removeSelectedEmployee(){
                let self = this

                this.$store.state.notification.employeeCandidates = [] //reset the first time
                self.searchText = ''

                self.selectedEmployee.employeeId = ''

                self.selectedEmployee.employeeNo = ''
                self.selectedEmployee.givenName = ''
                self.selectedEmployee.surname = ''

                self.recipientForm.employeeId = '' //remove from form object

                self.disableSubmitBtn = true
            },
            addRecipient(){
                let self = this

                if (self.recipientForm.employeeId && self.recipientForm.groupTypeId) {

                    self.$store.commit({
                        type: 'notification/createRecipient',
                        employeeId: self.recipientForm.employeeId,
                        groupTypeId: self.recipientForm.groupTypeId
                    })

                    //reset form
                    self.recipientForm = {
                        employeeId: '',
                        groupTypeId: ''
                    }

                } else {
                    alert('Form is not completed')
                }


            },
            removeRecipient(recipientId, index){
                let self = this

                if(confirm('Are you sure to remove this recipient?')){
                    if (recipientId) {
                        self.$store.commit({
                            type:'notification/removeRecipient',
                            recipientId:recipientId,
                            index:index
                        })
                    }
                }


            },
            createGroupType(){
                let self = this
                if (self.groupTypeForm.name) {

                    self.$store.commit({
                        type: 'notification/createGroupType',
                        name: self.groupTypeForm.name
                    })

                    self.groupTypeForm.name = '' //reset form

                } else {
                    alert('Name cannot be empty')
                }
            },
            sortRecipients(){
                let self = this
                this.$store.commit({
                    type:'notification/getNotificationRecipient',
                    groupTypeId:self.sortGroupTypeId
                })
            }
        }
    }
</script>