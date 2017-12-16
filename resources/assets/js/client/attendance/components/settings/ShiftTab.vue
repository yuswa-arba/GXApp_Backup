<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">Work Start</th>
                                        <th class="text-black">Work End</th>
                                        <th class="text-black">Break Start</th>
                                        <th class="text-black">Break End</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="shift in shifts">
                                        <td>{{shift.name}}</td>
                                        <td>{{shift.workStartAt}}</td>
                                        <td>{{shift.workEndAt}}</td>
                                        <td>{{shift.breakStartAt}}</td>
                                        <td>{{shift.breakEndAt}}</td>
                                        <td>
                                            <!--<i class="fs-14 fa fa-pencil pointer" v-if="shift.id!=1"></i>-->
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-times pointer" v-if="shift.id!=1"
                                               @click="deleteShift(shift.id)"></i>
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

        <div class="col-lg-4 m-b-10">
            <div class="card card-transparent">
                <div class="card-block">
                    <form id="shift-form">
                        <h4>Shift Form</h4>
                        <label class="help">(Format H:i e.g: 00:30 or 08:00 or 23:00)</label>
                        <div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Work Start</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="workstart" type="text" class="form-control"
                                                   v-model="workStartAt"
                                                   name="workStartAt">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Work End</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="workend" type="text" class="form-control" v-model="workEndAt"
                                                   name="workEndAt">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Break Start</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="breakstart" type="text" class="form-control"
                                                   name="breakStartAt" v-model="breakStartAt">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Break End</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="breakend" type="text" class="form-control"
                                                   name="breakEndAt" v-model="breakEndAt">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  required">
                                <label>Shift name</label>
                                <input type="text" class="form-control" required :placeholder="autoGeneratedShiftName"
                                       name="name">
                            </div>
                        </div>
                        <p>If time end is smaller than time start, the system will automatically registered it as a new
                            date/tomorrow's date</p>
                        <button class="btn btn-complete pull-right" type="button" @click="createShift()">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                shifts: [],
                workStartAt: '08:00',
                workEndAt: '17:00',
                breakStartAt: '12:00',
                breakEndAt: '13:00',
                formObject: {},
            }
        },
        created(){
            let self = this
            get(api_path() + 'component/list/shifts')
                .then((res) => {
                    self.shifts = res.data.data
                })
        },
        methods: {
            createShift(){
                let self = this
                let serializeForm = $('#shift-form').serializeArray()

                _.forEach(serializeForm, function (value, key) {
                    self.formObject[value.name] = value.value
                })

                post(api_path() + 'attendance/shift/create', self.formObject)
                    .then((res) => {
                        if (!res.data.isFailed && res.data.shift) {

                            //reset form
                            $('#shift-form input').val('')

                            /* Show success notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            // push to table
                            self.shifts.push(res.data.shift)

                        } else {
                            /* Show error notification */
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
                            message: err.message + '<br>' + err.response.data.errors.name[0],
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })

            },
            deleteShift(id){
                let self = this
                if(confirm('Are you sure to delete this shift?')){
                    post(api_path() + 'attendance/shift/delete', {shiftId: id})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                const shiftIndex = _.findIndex(self.shifts, {id: id})
                                self.shifts.splice(shiftIndex, 1)


                                /* Show success notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();


                            } else {
                                /* Show error notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            }

                        }).catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })

                }

            }
        },
        computed: {
            autoGeneratedShiftName: function () {
                let self = this
                let workStartAt = _.trimStart(_.trimEnd(self.workStartAt, '00'), '0')
                let workEndAt = _.trimStart(_.trimEnd(self.workEndAt, '00'), '0')

                return "e.g: " + _.trim(workStartAt, ':') + "to" + _.trim(workEndAt, ':')
            },
        }
    }
</script>