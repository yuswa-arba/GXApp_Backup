<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-menu"></slot>

        </div>


        <div class="col-lg-12 m-b-10 p-t-200" v-if="isFetchingSalaryReports">
            <!--Fetching data progress-->
            <div class="center-margin">
                <p class="text-center fs-21">Fetching Data.. Please wait..</p>
                <div class="progress h-8">
                    <div class="progress-bar-indeterminate progress-bar-success"></div>
                </div>
                <br>
            </div>
        </div>

        <!--employee data-->
        <div class="col-lg-12 m-b-10" v-if="employeeData && !isFetchingSalaryReports">
            <div class="card card-bordered">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block bg-primary" style="padding:3px 15px!important;">
                        <div class="pull-left">
                            <span class="text-white fs-16 bold">{{employeeData.employeeName}}</span>
                            <span class="text-white fs-16">({{employeeData.employeeNo}})</span>
                        </div>
                        <div class="pull-right">
                            <span class="text-white fs-14 bold">{{employeeData.divisionName}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--salary report-->
        <div class="col-lg-12 m-b-10" v-if="salaryReports && !isFetchingSalaryReports">
            <div class="card card-bordered filter-item" v-for="report in salaryReports">

                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="text-align: right;padding-right: 20px; margin-top: 10px;margin-bottom: 0px" class="bold">{{report.fromDate}} - {{report.toDate}}</h5>
                    </div>
                    <div class="col-lg-3">
                        <div class="card-block p-t-0" style="margin-left: 25px">
                            <h5 class="bold">Summary</h5>
                            <p class="fs-16">Basic Salary: <b class="text-primary">{{report.basicSalary}}</b></p>
                            <p class="fs-16">Total Bonus: <b class="text-primary">{{report.totalSalaryBonus}}</b></p>
                            <p class="fs-16">Total Cut: <b class="text-primary">{{report.totalSalaryCut}}</b></p>
                            <p class="fs-16">Salary Received: <b class="text-primary">{{report.salaryReceived}}</b></p>
                            <p class="fs-16">Status: <label
                                    class="label fs-16">{{report.confirmationStatusName}}</label></p>
                            <p class="fs-16">Postponed: <span v-if="report.isPostponed">Yes</span> <span
                                    v-else="">No</span></p>
                            <p class="fs-16">Submitted: <span v-if="report.isSubmittedForPayroll">Yes</span> <span
                                    v-else="">No</span></p>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-block p-t-0">
                            <h5 class="bold">Bonus/Cuts</h5>
                            <div class="scrollable">
                                <div style="height: 350px">
                                    <div class="table-responsive">
                                        <table class="table" v-if="report.salaryCalculations">
                                            <thead class="bg-master-lighter">
                                            <tr>
                                                <th>Name</th>
                                                <th>Add/Sub</th>
                                                <th>Insert</th>
                                                <th>Value</th>
                                                <th>Details</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="calculation in report.salaryCalculations">
                                                <td>{{calculation.SBCTypeName}}</td>
                                                <td>
                                                    <label v-if="calculation.SBCTypeAddOrSub=='add'"
                                                           class="label label-success fs-16">Add</label>
                                                    <label v-else="label label-danger fs-16">Sub</label>
                                                </td>
                                                <td>
                                                    At <b>{{calculation.insertedDate}}</b> by <b>{{calculation.insertedBy}}</b>
                                                </td>
                                                <td>{{calculation.value}}</td>
                                                <td>
                                                    <p class="fs-14">Edited: <span class="bold"
                                                                                   v-if="calculation.isEdited">Yes (by {{calculation.editedB}} at {{calculation.editedDate}})</span>
                                                        <span class="bold" v-else="">No</span></p>
                                                </td>
                                                <td>
                                                    <p class="fs 14">Processed: <span class="bold"
                                                                                      v-if="calculation.isProcessed">Yes (at {{calculation.processedDate}})</span>
                                                        <span class="bold" v-else="">No</span></p>
                                                </td>
                                                <td>
                                                    <p class="fs-14" v-if="calculation.notes">Notes: {{calculation.notes}}</p>
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
                employeeData: {},
                salaryReports: [],
                isFetchingSalaryReports: true
            }
        },
        created(){
            let self = this
            get(api_path + 'salary/employee/history/' + self.$route.params.id)
                .then((res) => {
                    if (!res.data.isFailed) { // success

                        //stop loading animation
                        self.isFetchingSalaryReports = false

                        //insert data too array
                        self.employeeData = res.data.employeeData
                        self.salaryReports = res.data.reportResult


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
        methods: {}
    }
</script>