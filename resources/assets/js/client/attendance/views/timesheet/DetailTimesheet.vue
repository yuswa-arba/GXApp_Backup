<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-menu"></slot>

        </div>


        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Timesheet Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee</label>
                            <p class="text-primary">
                                {{timesheetDetail.employeeName}}
                            </p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Divison</label>
                            <p class="text-black">{{timesheetDetail.divisionName}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Shift</label>
                            <p class="text-black">{{timesheetDetail.shiftName}}({{timesheetDetail.shiftWorkStartAt}} -
                                {{timesheetDetail.shiftWorkEndAt}})</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label> Approval Stats</label>
                            <p class="text-black" v-if="timesheetDetail.attendanceApproveId!=0">
                                {{timesheetDetail.attendanceApproveName}}</p>
                            <p v-else="">-</p>

                            <p v-if="timesheetDetail.approvedBy">by: {{timesheetDetail.approvedBy}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Validation Stats</label>
                            <p class="text-black" v-if="timesheetDetail.attendanceValidationId!=0">
                                {{timesheetDetail.attendanceValidationName}}</p>
                            <p v-else="">-</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Clocking Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Clock-In</label>
                            <p class="text-black" v-if="timesheetDetail.clockInTime">
                                Via: {{timesheetDetail.clockInViaType}}
                                {{timesheetDetail.clockInDate}} @<span class="bold">{{timesheetDetail.clockInTime}}</span>
                            </p>
                            <div class="clearfix"></div>
                            <img v-if="timesheetDetail.clockInPhoto"
                                 height="120px"
                                 class="img-responsive"
                                 :src="'/images/attendances/'+timesheetDetail.clockInPhoto" alt="">
                            <hr>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 employee-details">
                            <label>Clock-Out</label>
                            <p class="text-black" v-if="timesheetDetail.clockOutTime">
                                Via: {{timesheetDetail.clockOutViaType}}
                                {{timesheetDetail.clockOutDate}} @<span class="bold">{{timesheetDetail.clockOutTime}}</span>
                            </p>
                            <div class="clearfix"></div>
                            <img v-if="timesheetDetail.clockOutPhoto"
                                 height="120px"
                                 class="img-responsive"
                                 :src="'/images/attendances/'+timesheetDetail.clockOutPhoto" alt="">
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 employee-details">
                            <label>Misc.</label>
                            <p>Kiosk In: <span>{{timesheetDetail.clockInKiosk}}</span></p>
                            <p>Kiosk Out: <span>{{timesheetDetail.clockOutKiosk}}</span></p>

                            <p>IP Addr. In: <span>{{timesheetDetail.clockInIpAddress}}</span></p>
                            <p>IP Addr. Out: <span>{{timesheetDetail.clockOutIpAddress}}</span></p>

                            <p>Browser In: <span>{{timesheetDetail.clockInBrowser}}</span></p>
                            <p>Browser Out: <span>{{timesheetDetail.clockOutBrowser}}</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script type="text/javascript">
    import {get} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                timesheetDetail: {}
            }
        },
        created(){
            let self = this
            let timesheetId = this.$route.params.id
            get(api_path + 'attendance/timesheet/detail/' + timesheetId)
                .then((res) => {
                    self.timesheetDetail = res.data.data
                })
                .catch((err) => {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();
                    this.$router.go(-1)
                })
        }
    }
</script>