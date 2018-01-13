<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">

            <div class="pull-left m-r-15 m-b-10">
                <div class="dropdown dropdown-default">
                    <button class="btn btn-info dropdown-toggle text-center" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item pointer" @click="checkSchedule()">Refresh</a>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover scheduleDT">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black">ID</th>
                                <th class="text-black">Name</th>
                                <th class="text-black">Work Start</th>
                                <th class="text-black">Work End</th>
                                <th class="text-black">Overnight</th>
                                <th class="text-black">Allow Check In</th>
                                <th class="text-black">Allow Check Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="schedule in schedules">
                                <td>{{schedule.shiftId}}</td>
                                <td>{{schedule.shiftName}}</td>
                                <td>{{schedule.workStartAt}}</td>
                                <td>{{schedule.workEndAt}}</td>
                                <td>
                                    <i v-if="schedule.isOvernight" class="fa fa-check text-success fs-14"></i>
                                    <i v-else="" class="fa fa-times text-danger fs-14"></i>
                                </td>
                                <td>
                                    <i v-if="schedule.allowToCheckIn" class="fa fa-check text-success fs-14"></i>
                                    <i v-else="" class="fa fa-times text-danger fs-14"></i>
                                </td>
                                <td>
                                    <i v-if="schedule.allowToCheckOut" class="fa fa-check text-success fs-14"></i>
                                    <i v-else="" class="fa fa-times text-danger fs-14"></i>
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
    import {get, post} from'../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{

        data(){
            return {
                schedules: []
            }
        },
        computed: {},
        created(){
            let self = this
            get(api_path + 'attendance/schedule')
                .then((res) => {
                    if (!res.data.isFailed) {
                        if (res.data.schedule) {
                            self.schedules = res.data.schedule.data
                        }

                    } else {
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
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                })


        },
        methods: {


            checkSchedule(){
                get(api_path + 'attendance/schedule/check')
                    .then((res) => {
                        if (res.status == 200) {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: "Schedule is being refreshed and checked",
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        }
                    })
                    .catch((err) => {
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


    }
</script>