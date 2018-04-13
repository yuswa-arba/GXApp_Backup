<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">

            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortDivisionId"
                            @change="sortLeaveSchedule()">
                        <option value="">All Division</option>
                        <option :value="division.id" v-for="division in divisions">{{division.name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortLeaveApprovalId"
                            @change="sortLeaveSchedule()">
                        <option value="">All Approvals</option>
                        <option :value="approval.id" v-for="approval in leaveApprovals">{{approval.name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortLeaveTypeId"
                            @change="sortLeaveSchedule()">
                        <option value="">All Types</option>
                        <option :value="type.id" v-for="type in leaveTypes">{{type.name}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortYear"
                            @change="sortLeaveSchedule()">
                        <option :value="2017+index" v-for="index in 20">{{2017+index}}</option>
                    </select>
                </div>
            </div>

            <div class="pull-left">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           style="width: 200px"
                           placeholder="Search Employee"
                           id="search-employee-box">
                </div>
            </div>

        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover leaveDT">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th style="width: 30px">
                                    <div class="checkbox check-success ">
                                        <input type="checkbox" id="all-leave-cb" @change="checkAllLeaves()">
                                        <label for="all-leave-cb" class="fs-16"></label>
                                    </div>
                                </th>
                                <th class="text-black" style="width: 50px">ID</th>
                                <th class="text-black">Employee</th>
                                <th class="text-black">Date</th>
                                <th class="text-black" style="width: 150px!important">Total Day(s)</th>
                                <th class="text-black">Desc.</th>
                                <th class="text-black">Type</th>
                                <th class="text-black">Apprv</th>
                                <th>
                                    <div class="form-group m-t-10"
                                         v-if="selectedLeaveRequestIds.length>0"
                                         :class="{'hide':selectedLeaveRequestIds.length==0}">
                                        <select class="btn btn-info h-35 w-150 text-center"
                                                @change="answerLeaves()"
                                                v-model="answerLeaveApprovalId">
                                            <option value="" selected hidden disabled>Answer</option>
                                            <option :value="approval.id" v-for="approval in leaveApprovals">
                                                {{approval.name}}
                                            </option>
                                        </select>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(leave,index) in leaveSchedules" class="filter-employee">
                                <td>
                                    <div class="checkbox check-success ">
                                        <input type="checkbox" :id="'leave-cb-'+index"
                                               @change="toggleLeaveCb(index,leave.id)">
                                        <label :for="'leave-cb-'+index"></label>
                                    </div>
                                </td>
                                <td>{{leave.id}}</td>
                                <td><b>{{leave.employeeName}}</b> ({{leave.employeeDivisionName}})</td>

                                <td v-if="leave.fromDate==leave.toDate">{{leave.fromDate}}</td>
                                <td v-else="">{{leave.fromDate}} - {{leave.toDate}}</td>

                                <td>{{leave.totalDays}} <label v-if="leave.isStreakPaidLeave==1"
                                                               class="label label-success">Streak</label></td>
                                <td>{{leave.description}}</td>
                                <td>{{leave.leaveTypeName}}</td>
                                <td>{{leave.leaveApprovalName}}</td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    import {get, post} from'../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    import series from 'async/series';
    export default{

        data(){
            return {
                sortYear: moment().year(),
                sortDivisionId: '',
                sortLeaveTypeId: '',
                sortLeaveApprovalId: '',
                answerLeaveApprovalId: ''

            }
        },
        mounted(){
            $('.filter-container').sieve({
                searchInput: $('#search-employee-box'),
                itemSelector: ".filter-employee"
            });
        },
        computed: {
            ...mapState('leave', {
                leaveSchedules: 'leaveSchedules',
                divisions: 'divisions',
                leaveApprovals: 'leaveApprovals',
                leaveTypes: 'leaveTypes',
                selectedLeaveRequestIds: 'selectedLeaveRequestIds'
            })
        },
        created(){
            let self = this
            this.$store.dispatch('leave/getDataOnCreate')
        },
        methods: {
            sortLeaveSchedule(){
                let self = this

                this.$store.dispatch({
                    type: 'leave/sortLeaveSchedule',
                    sortYear: self.sortYear,
                    sortDivisionId: self.sortDivisionId,
                    sortLeaveTypeId: self.sortLeaveTypeId,
                    sortLeaveApprovalId: self.sortLeaveApprovalId
                })
            },
            toggleLeaveCb(index, leaveId){

                let self = this
                let leaveVuexState = this.$store.state.leave
                let leaveCb = $('#leave-cb-' + index)

                if (leaveCb.prop('checked')) {

                    leaveVuexState.selectedLeaveRequestIds.push(leaveId)//push to array

                } else {

                    let leaveIndex = _.findIndex(leaveVuexState.selectedLeaveRequestIds, (o) => { //get index of this leave id
                        return o == leaveId
                    })

                    leaveVuexState.selectedLeaveRequestIds.splice(leaveIndex, 1)//remove from array

                    //unchecked all leave cb
                    $('#all-leave-cb').prop('checked', false)


                }

            },
            checkAllLeaves(){

                let self = this
                let leaveVuexState = this.$store.state.leave
                let totalLeaveIds = leaveVuexState.leaveSchedules.length + 1//total leaves
                let allLeaveCb = $('#all-leave-cb')

                //reset the first time
                leaveVuexState.selectedLeaveRequestIds = []

                if (allLeaveCb.prop('checked')) { // check all

                    for (let i = 0; i < totalLeaveIds; i++) {

                        let cb = $('#leave-cb-' + i)
                        cb.prop('checked', true)

                        if (i < totalLeaveIds - 1) { // do not include the last one
                            leaveVuexState.selectedLeaveRequestIds.push(leaveVuexState.leaveSchedules[i].id)
                        }

                    }

                } else { //uncheck all
                    for (let i = 0; i < totalLeaveIds; i++) {
                        let cb = $('#leave-cb-' + i)
                        cb.prop('checked', false)
                    }

                    leaveVuexState.selectedLeaveRequestIds = []

                }
            },
            answerLeaves(){

                let self = this
                let leaveVuexState = this.$store.state.leave
                let totalLeaveIds = leaveVuexState.leaveSchedules.length + 1//total leaves
                let allLeaveCb = $('#all-leave-cb')

                if (self.answerLeaveApprovalId != '') {


                    series([
                        function(cb){

                            //send data to server
                            self.$store.dispatch({
                                type: 'leave/answerLeaveSchedule',
                                leaveApprovalId: self.answerLeaveApprovalId
                            })

                            cb(null,'')
                        },
                        function(cb){

                            //uncheck all items
                            for (let i = 0; i < totalLeaveIds; i++) {
                                let cb = $('#leave-cb-' + i)
                                cb.prop('checked', false)
                            }

                            allLeaveCb.prop('checked', false)

                            //reset state value
                            leaveVuexState.selectedLeaveRequestIds = []

                            // reset
                            // self.sortYear = moment().year()
                            // self.sortDivisionId = ''
                            // self.sortLeaveTypeId = ''
                            // self.sortLeaveApprovalId = ''
                             self.answerLeaveApprovalId = ''
                             $('#search-employee-box').val('')

                            setTimeout(()=>{
                                self.sortLeaveSchedule()
                            },1000)


                            cb(null,'')
                        }
                    ])

                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Answer cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            }

        },


    }
</script>