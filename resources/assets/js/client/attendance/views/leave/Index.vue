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

        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover leaveDT">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black" style="width: 50px">ID</th>
                                <th class="text-black">Employee</th>
                                <th class="text-black">Date</th>
                                <th class="text-black" style="width: 100px">Total Day(s)</th>
                                <th class="text-black">Desc.</th>
                                <th class="text-black">Type</th>
                                <th class="text-black">Apprv</th>
                                <th class="text-black"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="leave in leaveSchedules">
                                <td>{{leave.id}}</td>
                                <td><b>{{leave.employeeName}}</b> ({{leave.employeeDivisionName}})</td>

                                <td v-if="leave.fromDate==leave.toDate">{{leave.fromDate}}</td>
                                <td v-else="">{{leave.fromDate}} - {{leave.toDate}}</td>

                                <td>{{leave.totalDays}}  <label v-if="leave.isStreakPaidLeave==1" class="label label-success">Streak</label></td>
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
    import {mapGetters,mapState} from 'vuex'
    import {get, post} from'../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{

        data(){
            return {
                sortYear: '',
                sortDivisionId: '',
                sortLeaveTypeId: '',
                sortLeaveApprovalId: ''
            }
        },
        mounted(){
            console.log('my:' + moment().year())
            this.sortYear = moment().year()
        },
        computed: {
            ...mapState('leave',{
                leaveSchedules:'leaveSchedules',
                divisions:'divisions',
                leaveApprovals:'leaveApprovals',
                leaveTypes:'leaveTypes'
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
                    type:'leave/sorLeaveSchedule',
                    sortYear: self.sortYear,
                    sortDivisionId: self.sortDivisionId,
                    sortLeaveTypeId: self.sortLeaveTypeId,
                    sortLeaveApprovalId: self.sortLeaveApprovalId
                })
            }

        },


    }
</script>