<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">

            <div class="pull-left m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-150" v-model="sortDivisionId">
                        <option value="">Division</option>
                        <option :value="division.id" v-for="division in divisions">{{division.name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="pull-left m-r-15">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 " style="width:100px" v-model="sortShiftId">
                        <option value="">Shifts</option>
                        <option :value="shift.id" v-for="shift in shifts">{{shift.name}}
                        </option>
                    </select>
                </div>
            </div>


            <div class="pull-right m-r-15">
                <div class="form-group required">
                    <div class="input-group bootstrap-timepicker">
                        <input id="sortTimesheetDate" type="text" class="form-control" name="sortTimesheetDate"
                               required>
                        <span class="input-group-addon bg-primary text-white"  @click="sortTimesheet()"><i class="fa fa-check"></i></span>
                    </div>
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
                                <th class="text-black">Clock-In</th>
                                <th class="text-black">Clock-Out</th>
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
                                    <img v-if="timesheet.clockInPhoto"
                                         height="120px"
                                         class="img-responsive"
                                         :src="'/images/attendances/'+timesheet.clockInPhoto" alt="">

                                    <p v-if="timesheet.clockInTime" class="fs-16 m-t-10 text-primary text-center bold">{{timesheet.clockInTime}}</p>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <img v-if="timesheet.clockOutPhoto"
                                         height="120px"
                                         class="img-responsive"
                                         :src="'/images/attendances/'+timesheet.clockOutPhoto" alt="">

                                    <p v-if="timesheet.clockOutTime" class="fs-16 m-t-10 text-primary text-center bold"> {{timesheet.clockOutTime}}</p>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <p v-if="timesheet.attendanceApproveName">{{timesheet.attendanceApproveName}}</p>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <p v-if="timesheet.attendanceValidationName"> {{timesheet.attendanceValidationName}}</p>
                                    <p v-else="">-</p>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary">Approve</button>
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
                sortDivisionId:'',
                sortShiftId:'',
                sortDate: ''
            }
        },
        computed:{
            ...mapGetters('timesheet',{
                divisions:'divisions',
                shifts:'shifts',
                timesheetDatas:'timesheetDatas'
            }),

        },
        created(){

            let self =this
            this.$store.dispatch('timesheet/getDataOnCreate')


        },
        methods:{
            sortTimesheet(){

                let self = this
                let sortDate = moment().format('DD/MM/YYYY')

                if($('#sortTimesheetDate').val()){
                    sortDate = $('#sortTimesheetDate').val()
                }

                this.$store.dispatch({
                    type: 'timesheet/getSortedData',
                    divisionId: self.sortDivisionId,
                    shiftId: self.sortShiftId,
                    sortDate:sortDate
                })
            },

        }
    }
</script>