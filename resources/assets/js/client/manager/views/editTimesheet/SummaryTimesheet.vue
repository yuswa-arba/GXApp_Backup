<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
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
                            <table class="table table-hover table-text-center" id="summaryDT">
                                <thead class="bg-master-lighter">
                                <tr>
                                    <th class="text-black w-150">Date</th>
                                    <th class="text-black"></th>
                                    <th class="text-black">Clock In</th>
                                    <th class="text-black">Clock Out</th>
                                    <th class="text-black">Work Hours</th>
                                    <th class="text-black">c-In Late(min)</th>
                                    <th class="text-black">c-Out Early(min)</th>
                                    <th class="text-black">c-Out Late(min)</th>
                                    <th class="text-black">Shift</th>
                                    <th class="text-black">Valid</th>
                                    <th class="text-black">Apprv</th>
                                    <th class="text-black" style="width: 70px"></th>
                                    <th class="text-black"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(timesheet,index) in summary.timesheet">
                                    <td>{{timesheet.date}} ({{timesheet.day}})</td>
                                    <td v-if="timesheet.type.isHoliday" class="holiday-cell">{{timesheet.type.notes}}
                                    </td><!--holiday-->
                                    <td v-else-if="!timesheet.detail.data[0]&&!timesheet.type.isHoliday"
                                        class="absence-cell">A
                                    </td> <!--absence-->
                                    <td v-else=""></td><!--normal day-->
                                    <td>
                                        <span v-if="timesheet.detail.data[0] && !timesheet.editing">{{timesheet.detail.data[0].clockInTime}}</span>
                                        <input :name="'cInTime'+summary.employee.data.employeeNo+index"
                                               class="form-control text-center w-80"
                                               v-else-if="timesheet.editing && timesheet.detail.data[0] && timesheet.detail.data[0].clockInTime"
                                               :value="timesheet.detail.data[0].clockInTime"/>
                                        <input :name="'cInTime'+summary.employee.data.employeeNo+index"
                                               placeholder="HH:mm"
                                               class="form-control text-center w-80" v-else-if="timesheet.editing"/>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0] && !timesheet.editing">{{timesheet.detail.data[0].clockOutTime}}</span>
                                        <input :name="'cOutTime'+summary.employee.data.employeeNo+index"
                                               class="form-control text-center w-80"
                                               v-else-if="timesheet.editing && timesheet.detail.data[0] && timesheet.detail.data[0].clockOutTime"
                                               :value="timesheet.detail.data[0].clockOutTime"/>
                                        <input :name="'cOutTime'+summary.employee.data.employeeNo+index"
                                               placeholder="HH:mm"
                                               class="form-control text-center w-80" v-else-if="timesheet.editing"/>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].workHour}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckInLate}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckOutEarly}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].minutesCheckOutLate}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span v-if="timesheet.detail.data[0] && !timesheet.editing">{{timesheet.detail.data[0].shiftId}}</span>
                                        <select :name="'selectShift'+summary.employee.data.employeeNo+index"
                                                class="form-control w-70"
                                                v-else-if="timesheet.editing && !timesheet.detail.data[0]">
                                            <option :value="shift.id" v-for="shift in shifts">{{shift.name}}</option>
                                        </select>
                                        <select :name="'selectShift'+summary.employee.data.employeeNo+index"
                                                class="form-control w-70"
                                                v-else-if="timesheet.editing && timesheet.detail.data[0]">
                                            <option :value="timesheet.detail.data[0].shiftId" readonly>
                                                {{timesheet.detail.data[0].shiftName}}
                                            </option>
                                            <option :value="shift.id" v-for="shift in shifts">{{shift.name}}</option>
                                        </select>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span class="fs-10" v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].attendanceValidationName}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td>
                                        <span class="fs-10" v-if="timesheet.detail.data[0]">{{timesheet.detail.data[0].attendanceApproveName}}</span>
                                        <span v-else="">-</span>
                                    </td>
                                    <td :class="{'w-60':timesheet.detail.data[0] && timesheet.detail.data[0].attendanceApproveId==99}">
                                        <div v-if="timesheet.allowToEdit">
                                             <span v-if="timesheet.detail.data[0] && timesheet.detail.data[0].attendanceApproveId==99">
                                        <i class="fa fa-check text-success cursor"
                                           @click="approveTimesheet(timesheet.detail.data[0].id)"></i> &nbsp;
                                        <i class="fa fa-times text-danger cursor"
                                           @click="disapproveTimesheet(timesheet.detail.data[0].id)"></i>
                                        </span>


                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="timesheet.allowToEdit">
                                        <i class="fa fa-pencil cursor" v-if="!timesheet.editing"
                                           @click="editTimesheet(index,summary.employee.data.employeeNo)"></i>
                                        <div v-else="timesheet.editing">
                                             <span class="fs-12 text-danger cursor"
                                                   v-if="timesheet.detail.data[0] && timesheet.detail.data[0].id"
                                                   @click="doneEditTimesheet(index,summary.employee.data.id,summary.employee.data.employeeNo,timesheet.detail.data[0].id,timesheet.date)">DONE</span>
                                            <span class="fs-12 text-danger cursor"
                                                  v-else=""
                                                  @click="doneEditTimesheet(index,summary.employee.data.id,summary.employee.data.employeeNo,'',timesheet.date)">DONE</span>
                                        </div>
                                        </div>
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

</template>
<script type="text/javascript">
    import {mapState, mapGetters} from 'vuex'
    export default{
        components: {

        },
        data(){
            return {}
        },
        computed: {
            ...mapState('editTimesheet', {
                timesheetSummaryData: 'timesheetSummaryData',
                shifts: 'shifts'
            })
        },
        created(){

            this.$store.commit({
                type:'editTimesheet/getShifts'
            })

            this.$store.commit({
                type:'editTimesheet/getTimesheetSummaryData',
                editTimesheetId:this.$route.params.editTimesheetId
            })
        },
        mounted() {

        },
        methods: {
            approveTimesheet(timesheetId){
                if (timesheetId)
                    this.$store.commit('editTimesheet/approveTimesheetFromSummary', timesheetId)
            },
            disapproveTimesheet(timesheetId){
                if (timesheetId)
                    this.$store.commit('editTimesheet/disapproveTimesheetFromSummary', timesheetId)
            },
            editTimesheet(index, employeeNo){
                this.$store.dispatch({
                    type: 'editTimesheet/editTimesheet',
                    index: index,
                    employeeNo: employeeNo
                })
            },
            doneEditTimesheet(index, employeeId, employeeNo, timesheetId, date){

                let cInTime = $('input[name="' + 'cInTime' + employeeNo + index + '"]').val()
                let cOutTime = $('input[name="' + 'cOutTime' + employeeNo + index + '"]').val()
                let selectedShift = $('select[name="' + 'selectShift' + employeeNo + index + '"]').val()
                let cInValid = false
                let cOutValid = false

                /* Validate time format */
                if (cInTime && cOutTime) {
                    if (moment(cInTime, "HH:mm", true).isValid()) {
                        cInValid = true
                    } else {
                        cInValid = false
                        alert('Clock In time format is not valid (use 00:00 - 23:59 format)')
                    }

                    if (moment(cOutTime, "HH:mm", true).isValid()) {
                        cOutValid = true
                    } else {
                        cOutValid = false
                        alert('Clock Out time format is not valid (use 00:00 - 23:59 format)')
                    }

                } else {

                    this.$store.dispatch({
                        type: 'editTimesheet/cancelEditTimesheet',
                        index: index,
                        employeeNo: employeeNo,
                    })

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Clock In & Clock Out cannot be empty. Edit canceled.',
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();
                }


                if (cInValid && cOutValid && selectedShift && employeeId && date && employeeNo) {

                    if (timesheetId) {
                        this.$store.dispatch({
                            type: 'editTimesheet/saveEditTimesheet',
                            index: index,
                            employeeNo: employeeNo,
                            clockInTime: cInTime,
                            clockOutTime: cOutTime,
                            shiftId: selectedShift,
                            date: date,
                            timesheetId: timesheetId
                        })
                    } else {
                        this.$store.dispatch({
                            type: 'editTimesheet/createNewTimesheet',
                            index: index,
                            employeeId: employeeId,
                            employeeNo: employeeNo,
                            clockInTime: cInTime,
                            clockOutTime: cOutTime,
                            shiftId: selectedShift,
                            date: date
                        })
                    }

                }

            }
        }

    }
</script>