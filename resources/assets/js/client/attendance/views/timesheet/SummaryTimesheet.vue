<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-menu"></slot>
            <div class="pull-right m-r-15">
                <p><span class="bold text-black">From: </span> {{generateFromDate}} <span
                        class="bold text-black"> &nbsp; To: </span>{{generateToDate}}</p>
            </div>
        </div>

        <div class="col-lg-12 m-b-10 ">
            <div class="m-b-20 filter-item" v-for="summary in timesheetSummaryData">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block bg-primary" style="padding:3px 15px!important;">
                        <div class="pull-left">
                            <span class="text-white fs-16 bold">{{summary.employee.data.employeeName}}</span>
                            <span class="text-white fs-16">({{summary.employee.data.employeeNo}})</span>
                        </div>
                        <div class="pull-right">
                            <span class="text-white fs-14 bold">{{summary.employee.data.divisionName}}</span>
                            <span class="text-white fs-14">({{summary.employee.data.branchOfficeName}})</span>
                        </div>

                    </div>
                </div>
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-text-center" id="summaryDT">
                                <thead class="bg-master-lighter">
                                <tr>
                                    <th class="text-black">Date</th>
                                    <th class="text-black">Clock In</th>
                                    <th class="text-black">Clock Out</th>
                                    <th class="text-black">Work Hours</th>
                                    <th class="text-black">c-In Late(min)</th>
                                    <th class="text-black">c-Out Early(min)</th>
                                    <th class="text-black">c-Out Late(min)</th>
                                    <th class="text-black">Shift</th>
                                    <th class="text-black">Valid Stats.</th>
                                    <th class="text-black">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="timesheet in summary.timesheet">
                                    <td>{{timesheet.date}} ({{timesheet.day}})</td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].clockInTime}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].clockOutTime}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].workHour}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckInLate}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckOutEarly}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckOutLate}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].shiftName}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].attendanceValidationName}}</span> <span v-else="">-</span></td>
                                    <td><span v-if="timesheet.detail.data[0]"><i class="fa fa-check"></i></span> <span v-else="">-</span></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</template>
<script type="text/javascript">
    import {mapState} from 'vuex'
    export default{
        data(){
            return {}
        },
        computed: {
            ...mapState('timesheet', {
                generateFromDate: 'generateFromDate',
                generateToDate: 'generateToDate',
                timesheetSummaryData: 'timesheetSummaryData'
            })
        },
        created(){
            // if date is empty return back
            if (this.$store.state.timesheet.generateFromDate == '' || !this.$store.state.timesheet.generateToDate == '') {
                this.$router.push('/')
            }
        },
        mounted: function () {

        },
        created(){

        }
    }
</script>