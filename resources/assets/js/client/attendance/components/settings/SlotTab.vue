<template>
    <div class="row">
        <div class="col-lg-5 m-b-10 m-t-10">
            <div class="card no-border">
                <div class="card-block">
                    <div class="parent-center">
                        <p class="pull-left child-center fs-14">Allow employees to exchange slot</p>
                        <input class="pull-right child-center" type="checkbox">
                    </div>
                    <div class="clearfix"></div>
                    <div class="parent-center">
                        <p class="pull-left child-center fs-14">Allow exchange without confirmation</p>
                        <input class="pull-right child-center" type="checkbox">
                    </div>
                    <div class="clearfix"></div>
                    <div class="parent-center">
                        <p class="pull-left child-center fs-14">Allow managers to edit timesheets</p>
                        <input class="pull-right child-center" type="checkbox">
                    </div>
                    <div class="clearfix"></div>
                    <div class="parent-center">
                        <p class="pull-left child-center fs-14">Auto-sync slots</p>
                        <input class="pull-right child-center" type="checkbox">
                    </div>

                    <div class="clearfix"></div>
                    <p class="fs-12">If someone is not assigned to specific slot, he/she will be automatically assigned to default slot</p>
                    <p class="fs-12">Creating slot maker means only creating the setting, slot maker needs to be
                        executed from the
                        table below </p>
                    <p class="fs-12">Slot maker only generates day off based on the settings, it means working days is
                        all days(in the year
                        of the slot maker executed) EXCEPT the day-off days</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 m-b-10 m-t-10">
            <div class="card no-border">
                <div class="card-block">


                </div>
            </div>
        </div>
        <div class="col-lg-5 m-b-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <form id="slot-maker-form">
                        <h4>Slot Maker Form</h4>
                        <div>


                            <div class="form-group">
                                <label>Related to Job</label>
                                <input type="checkbox" name="relatedToJobPosition" v-model="isRelatedToJob" value="1">
                            </div>

                            <div v-if="isRelatedToJob">
                                <div class="form-group">
                                    <label>Job Position</label>
                                    <select class="form-control" name="jobPositionId" required>
                                        <option :value="jobPosition.id" v-for="jobPosition in jobPositions">
                                            {{jobPosition.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group  required">
                                        <label>Name <i class="fa fa-question-circle pointer"
                                                       @click="seeHow()"></i></label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>First Date</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="firstdate" type="text" class="form-control" name="firstDate"
                                                   required>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group  required">
                                        <label>Working Days</label>
                                        <input type="number" class="form-control" name="workingDays" value="6" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Total Day Loop</label>
                                        <input type="number" class="form-control" name="totalDayLoop" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  required">
                                <label>Allow Multiple Assign</label>
                                <select class="form-control" name="allowMultipleAssign" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-primary fs-14 pointer" @click="seeHow()">
                            See how
                        </p>
                        <button class="btn btn-primary pull-right" type="button" @click="createSlotMaker()">Save
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">First Date</th>
                                        <th class="text-black">Related to</th>
                                        <th class="text-black">Total Loop</th>
                                        <th class="text-black">Working Days</th>
                                        <th class="text-black">Multiple</th>
                                        <th class="text-black">Executed</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="slotMaker in slotMakers">
                                        <td style="width: 100px">{{slotMaker.name}}</td>
                                        <td>{{slotMaker.firstDate}}</td>
                                        <td>
                                            <p v-if="slotMaker.relatedToJobPosition==1">
                                                {{slotMaker.jobPosition}}
                                            </p>
                                            <p v-else>-</p>

                                        </td>
                                        <td>{{slotMaker.totalDayLoop}}</td>
                                        <td>{{slotMaker.workingDays}}</td>
                                        <td>
                                            <p v-if="slotMaker.allowMultipleAssign==1">Yes</p>
                                            <p v-else>No</p>
                                        </td>
                                        <td>
                                            <p v-if="slotMaker.isExecuted==1">
                                                by {{slotMaker.executedBy}} at {{slotMaker.executedAt}}
                                            </p>
                                            <p v-else>-</p>
                                        </td>
                                        <td style="width: 70px">
                                            <!--<i class="fs-14 fa fa-search pointer"></i>-->
                                            <!--&nbsp;-->
                                            <i class="fs-14 text-success fa fa-power-off pointer"
                                               @click="execute(slotMaker.id,slotMaker.name)"
                                               v-if="slotMaker.isExecuted!=1"></i>
                                            <i class="fs-14 text-danger fa fa-power-off pointer" v-else></i>

                                            &nbsp;

                                            <i class="fs-14 text-success fa fa-refresh pointer"
                                               v-if="slotMaker.isExecuted==1"></i>
                                            <i class="fs-14 fa fa-refresh pointer" v-else></i>

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


        <!--SEE HOW MODAL-->
        <div class="modal  fade stick-up" id="modal-see-how" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg" style="width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-role"></div>-->
                        <h5 class="text-left dark-title p-b-5"> Create Slot Maker</h5>
                    </div>
                    <div class="modal-body">
                        <p><span class="bold">1. Name: </span>
                            It's basically just a name. However, we recommend this format:
                            <br>
                            <div class="p-l-10">
                                <span style="font-style: italic">JobPositionName_6D_17</span>
                                <br>
                                So you can use it like : <b>HouseHoldTrainee_5D_17</b>
                                <br>
                                It means this slot was made for <b>Household Trainee</b> on 20<b>17</b> and has <b>5</b>
                                working days
                            </div>

                        </p>
                        <p><span class="bold">2. First Date: </span> Data will be generated starting from this date
                            +total days in current year (recommend 1st of January)</p>
                        <p><span class="bold">3. Total Day Loop: </span> Day offs loop through the given value and add
                            day by 1.
                            <br>
                            <div class="p-l-10">
                                Example:
                                <br>
                                - Total day loop = 3
                                <br>
                                It will generate 3 slots with the rule -> day off add by 1 day from previous slot.
                                <br>
                                <b>Dayoffs:</b> <br>
                                Slot 1 : 12/01/2017,18/01/2017,25/01/2017... <br>
                                Slot 2 : 13/01/2017,19/01/2017,26/01/2017... <br>
                                Slot 3 : 14/01/2017,20/01/2017,27/01/2017... <br>
                            </div>
                        </p>
                        <p><span class="bold">4. Working Days: </span> Total working days before 1 day off</p>
                        <p><span class="bold">5. Allow multiple assign: </span> Can be assigned more than one individual
                        </p>
                        <p><span class="bold">6. Related to Job, Job Position: </span>
                            If slot maker is related to specific job position, <b>Total loop day</b> will be sync to total of employees with that specific job position
                        </p>

                    </div>
                    <div class="modal-footer">
                        <!--<div id="mf-role"></div>-->
                        <button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" @click="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <!--END OF SEE HOW MODAL-->
    </div>
</template>
<script type="text/javascript">

    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'

    export default{

        data(){
            return {
                slotMakers: [],
                jobPositions: [],
                formObject: {},
                isRelatedToJob: false
            }
        },
        mounted(){
            $('#firstdate').val('01/01/' + new Date().getFullYear())
        },
        created(){

            let self = this

            get(api_path + 'component/list/jobPosition')
                .then((res) => {
                    self.jobPositions = res.data.data
                })

            get(api_path + 'attendance/slotMaker/list')
                .then((res) => {
                    self.slotMakers = res.data.data

                    // fix datatables Bug displaying "no data available"
                    if (!_.isEmpty(self.slotMakers)) {
                        $('.dataTables_empty').hide()
                    }

                })

        },
        methods: {
            createSlotMaker(){
                let self = this

                let serializeForm = $('#slot-maker-form').serializeArray()

                _.forEach(serializeForm, function (value, key) {
                    self.formObject[value.name] = value.value
                })

                post(api_path + 'attendance/slotMaker/create', self.formObject)
                    .then((res) => {
                        if (!res.data.isFailed && res.data.slotMaker) {

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            // reset form
                            $('#slot-maker-form input').val('')
                            $('#slot-maker-form select').val('')
                            self.isRelatedToJob = false

                            // push to table
                            self.slotMakers.push(res.data.slotMaker)

                            // fix datatables Bug displaying "no data available"
                            if (!_.isEmpty(self.slotMakers)) {
                                $('.dataTables_empty').hide()
                            }


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
                            message: err.message + "<br>" + err.response.data.errors.name[0],
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })
            },
            execute(slotMakerId, slotMakerName){

                let self = this;

                if (confirm('Are you sure to execute slot maker : ' + slotMakerName + ' ?')) {
                    post(api_path + 'attendance/slotMaker/execute', {id: slotMakerId})
                        .then((res) => {

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            self.slotMakers = res.data.slotMakers
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

            seeHow(){
                $('#modal-see-how').modal('show')
            },

            closeModal(){
                $('#modal-see-how').modal("toggle"); // close modal
            }

        }
    }

</script>