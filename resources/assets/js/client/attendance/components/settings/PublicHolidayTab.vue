<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <!--<div class="card-header"></div>-->
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-350">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-text-center settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">ID</th>
                                        <th class="text-black">Date</th>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">Religion</th>
                                        <th class="text-black">General</th>
                                        <th class="text-black">Applied</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(pubHoliday,index) in publicHolidays">
                                        <td>{{pubHoliday.id}}</td>
                                        <td>{{pubHoliday.date}}</td>
                                        <td>{{pubHoliday.name}}</td>
                                        <td>{{pubHoliday.religionName}}</td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check" v-if="pubHoliday.isGeneral"></i>
                                            <i class="fs-16 text-danger fa fa-times" v-else=""></i>
                                        </td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check" v-if="pubHoliday.isApplied"></i>
                                            <i class="fs-16 text-danger fa fa-times" v-else=""></i>
                                        </td>
                                        <td>
                                            <i class="fs-14 text-success fa fa-play pointer" v-if="!pubHoliday.isApplied"></i>
                                            <i class="fs-14 fa fa-play" v-else=""></i>
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-trash pointer"
                                               v-if="!pubHoliday.isApplied" @click="deletePublicHoliday(pubHoliday.id,index)"></i>
                                            <i class="fs-14 fa fa-trash" v-else=""></i>
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
                    <form id="pub-holiday-form">
                        <h4>Public Holiday Form</h4>

                        <div class="form-group ">
                            <label>Holiday name</label>
                            <input type="text" class="form-control" v-model="formObject.holidayName">
                        </div>
                        <div class="form-group ">
                            <label>On Year</label>
                            <input type="number" max="9998" class="form-control" v-model="formObject.onYear">
                        </div>
                        <div class="form-group form-group-default-select2">
                            <label class="">Religion</label>
                            <select class="form-control" v-model="formObject.religionId">
                                <!--<option value="" disabled selected hidden>Select Religion</option>-->
                                <!--<option value="all">All</option>-->
                                <option :value="religion.id" v-for="religion in religions">{{religion.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date Start - Date End </label>
                            <div class="input-daterange input-group" id="holiday-datepicker-range">
                                <input type="text" class="input-sm form-control" name="dateStart"
                                       v-model="formObject.dateStart"/>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="input-sm form-control" name="dateEnd"
                                       v-model="formObject.dateEnd"/>
                            </div>
                        </div>
                        <p>
                            If ALL religion is selected, then this holiday will be applied to all employees, otherwise
                            it will be applied
                            to employees with selected religion.
                        </p>
                        <button class="btn btn-complete pull-right" type="button" @click="createPublicHoliday()">Save
                        </button>
                    </form>
                    <div class="clearfix"></div>
                    <br>
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
                religions: [],
                formObject: {
                    dateStart: '',
                    dateEnd: '',
                    holidayName: '',
                    onYear: moment().year(),
                    religionId: ''
                },
                publicHolidays: []
            }
        },
        created(){
            let self = this

            //get religions list
            get(api_path + 'component/list/religion')
                .then((res) => {
                    self.religions = res.data.data
                })

            //get public holidays
            get(api_path + 'attendance/pubHoliday/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        self.publicHolidays = res.data.publicHolidays.data
                    }
                })

        },
        methods: {
            createPublicHoliday(){
                let self = this


                self.formObject.dateStart = $('input[name="dateStart"]').val()
                self.formObject.dateEnd = $('input[name="dateEnd"]').val()

                post(api_path + 'attendance/pubHoliday/create', self.formObject)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            self.publicHolidays = res.data.publicHolidays.data;

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                        } else {
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

            },
            deletePublicHoliday(id,index){
                let self = this

                if(confirm('Are you sure you want to delete this public holiday?')){
                    post(api_path + 'attendance/pubHoliday/delete', {id:id})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                self.publicHolidays.splice(index,1)

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                            } else {
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
        }
    }
</script>