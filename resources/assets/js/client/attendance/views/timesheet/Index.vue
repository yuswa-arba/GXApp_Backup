<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">

            <div class="pull-left m-r-15">
                <button class="btn btn-info">Summary</button>
            </div>

            <div class="pull-right m-r-15">
                <div class="form-group required">
                    <div class="input-group bootstrap-timepicker">
                        <input id="sortTimesheetDate" type="text" class="form-control" name="sortTimesheetDate"
                               required>
                        <span class="input-group-addon bg-primary text-white" @click="sortTimesheet()"><i
                                class="fa fa-check"></i></span>
                    </div>
                </div>
            </div>
            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 "
                            style="width:100px" v-model="sortShiftId"
                            @change="sortTimesheet()">
                        <option value="">All Shifts</option>
                        <option :value="shift.id" v-for="shift in shifts">{{shift.name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortDivisionId"
                            @change="sortTimesheet()">
                        <option value="">All Division</option>
                        <option :value="division.id" v-for="division in divisions">{{division.name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="pull-right m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150"
                            v-model="sortAttdApprovalId"
                            @change="sortTimesheet()">
                        <option value="">All Approval</option>
                        <option :value="attdApproval.id" v-for="attdApproval in attdApprovals">{{attdApproval.name}}
                        </option>
                    </select>
                </div>
            </div>




        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover timesheetDT">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black w-150">Employee</th>
                                <th class="text-black" style="width:100px">Shift</th>
                                <th class="text-black">Clock-In
                                    <i @click="showHidecInPhoto()"
                                       class="fa fa-eye cursor"
                                       v-if="showcInPhoto"
                                       style="color: darkgrey"></i>
                                    <i @click="showHidecInPhoto()"
                                       class="fa fa-eye-slash cursor"
                                       v-else=""
                                       style="color: darkgrey"></i>
                                </th>
                                <th class="text-black">Clock-Out
                                    <i @click="showHidecOutPhoto()"
                                       class="fa fa-eye cursor"
                                       v-if="showcOutPhoto"
                                       style="color: darkgrey"></i>
                                    <i @click="showHidecOutPhoto()"
                                       class="fa fa-eye-slash cursor"
                                       v-else=""
                                       style="color: darkgrey"></i>
                                </th>
                                <th class="text-black">Approve Stats</th>
                                <th class="text-black">Valid Stats</th>
                                <th class="text-black">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="timesheet in timesheetDatas" class="filter-item">
                                <td>
                                    <p class="fs-16 bold text-black m-b-0">{{timesheet.employeeName}}</p>
                                    {{timesheet.divisionName}}

                                </td>
                                <td>
                                    <p class="m-b-0 text-black bold"> {{timesheet.shiftName}}</p>
                                    <p class="m-b-0"> Start: {{timesheet.shiftWorkStartAt}}</p>
                                    <p class="m-b-0"> End: {{timesheet.shiftWorkEndAt}}</p>

                                </td>
                                <td>
                                    <img v-if="timesheet.clockInPhoto && showcInPhoto"
                                         height="120px"
                                         class="img-responsive"
                                         :id="'cInPhoto-'+timesheet.id"
                                         :src="'/images/attendances/'+timesheet.clockInPhoto" alt="">

                                    <button v-if="timesheet.clockInTime"
                                            class="btn btn-clock text-center m-t-10"
                                            style="width: 90px">
                                        {{timesheet.clockInTime}}
                                    </button>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <img v-if="timesheet.clockOutPhoto && showcOutPhoto"
                                         height="120px"
                                         class="img-responsive"
                                         :id="'cOutPhoto-'+timesheet.id"
                                         :src="'/images/attendances/'+timesheet.clockOutPhoto" alt="">

                                    <button v-if="timesheet.clockOutTime"
                                            class="btn btn-clock text-center m-t-10"
                                            style="width: 90px">{{timesheet.clockOutTime}}
                                    </button>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <label class="label label-lg fs-14"
                                           :class="{
                                           'label-default' : timesheet.attendanceApproveId==99,
                                           'label-info' : timesheet.attendanceApproveId!=99}"
                                           v-if="timesheet.attendanceApproveName">{{timesheet.attendanceApproveName}}</label>
                                    <p v-else="">-</p>

                                    <p v-if="timesheet.approvedBy">by: <span class="bold">{{timesheet.approvedBy}}</span></p>


                                </td>
                                <td>
                                    <label class="label label-lg fs-14"
                                           :class="{
                                           'label-danger' : timesheet.attendanceValidationId!=1,
                                           'label-info' : timesheet.attendanceValidationId==1}"
                                           v-if="timesheet.attendanceValidationName">
                                        {{timesheet.attendanceValidationName}}</label>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <button class="btn btn-primary" style="width: 80px">Details</button>

                                    <!-- Manager approval button-->
                                    <button class="btn btn-outline-info m-t-10"
                                            v-if="timesheet.attendanceApproveId!=1"
                                            @click="approveTimesheet(timesheet.id)"
                                            style="width: 80px">
                                        Approve <i class="fa fa-check"></i></button>
                                    <button class="btn btn-complete m-t-10"
                                            v-else=""
                                            style="width: 80px">
                                        Approved <i class="fa fa-check"></i></button>

                                </td>
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
    import {mapGetters} from 'vuex'
    export default{
        data(){
            return {
                sortDivisionId: '',
                sortShiftId: '',
                showcInPhoto: true,
                showcOutPhoto: true,
                sortAttdApprovalId:''
            }
        },
        computed: {
            ...mapGetters('timesheet', {
                divisions: 'divisions',
                shifts: 'shifts',
                attdApprovals:'attdApprovals',
                timesheetDatas: 'timesheetDatas'
            }),

        },
        created(){

            let self = this
            this.$store.dispatch('timesheet/getDataOnCreate')


        },
        methods: {
            sortTimesheet(){

                let self = this
                let sortDate = moment().format('DD/MM/YYYY')

                if ($('#sortTimesheetDate').val()) {
                    sortDate = $('#sortTimesheetDate').val()
                }

                this.$store.dispatch({
                    type: 'timesheet/getSortedData',
                    divisionId: self.sortDivisionId,
                    shiftId: self.sortShiftId,
                    sortDate: sortDate,
                    attdApprovalId:self.sortAttdApprovalId
                })
            },

            showHidecInPhoto(){
                let self = this
                if (self.showcInPhoto == true) {
                    self.showcInPhoto = false
                } else {
                    self.showcInPhoto = true
                }
            },
            showHidecOutPhoto(){
                let self = this
                if (self.showcOutPhoto == true) {
                    self.showcOutPhoto = false
                } else {
                    self.showcOutPhoto = true
                }
            },
            approveTimesheet(timesheetId){
                this.$store.commit('timesheet/saveApproveTimesheet',timesheetId)
            }

        }
    }
</script>