<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-6 m-b-10" v-if="!isFetchingReportDetail">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="row" v-if="salaryReportDetails.summary">
                        <div class="col-lg-6">
                            <p class="fs-21">Total Employees :
                                <b>{{salaryReportDetails.summary.totalEmployees}}</b></p>
                            <p class="fs-21">Branch Office :
                                <b>{{salaryReportDetails.summary.branchOfficeName}}</b></p>
                        </div>
                        <div class="col-lg-6">
                            <p class="fs-21">From Date : <b>{{salaryReportDetails.summary.fromDate}}</b></p>
                            <p class="fs-21">To Date : <b>{{salaryReportDetails.summary.toDate}}</b></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6 m-b-10">

        </div>


        <div class="col-lg-12 m-b-10" v-if="salaryReportDetails.details">
            <div class="filter-item card card-bordered" v-for="detail in salaryReportDetails.details">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block bg-primary" style="padding:3px 15px!important;" v-if="detail.employeeData">
                        <div class="pull-left">
                            <span class="text-white fs-16 bold">{{detail.employeeData.employeeName}}</span>
                            <span class="text-white fs-16">({{detail.employeeData.employeeNo}})</span>
                        </div>
                        <div class="pull-right">
                            <span class="text-white fs-14 bold">{{detail.employeeData.divisionName}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 m-b-10" v-if="detail.reportResult">
                    <div class="card card-borderless filter-item" v-for="report in detail.reportResult">

                        <div class="row">
                            <div class="col-lg-3 m-t-10" v-if="report.salaryReport">
                                <div class="card-block p-t-0" style="margin-left: 25px">
                                    <h5 class="bold">Summary</h5>
                                    <p class="fs-16">Basic Salary: <b class="text-primary">{{report.salaryReport.basicSalary}}</b></p>
                                    <p class="fs-16">Total Bonus: <b class="text-primary">{{report.salaryReport.totalSalaryBonus}}</b></p>
                                    <p class="fs-16">Total Cut: <b class="text-primary">{{report.salaryReport.totalSalaryCut}}</b></p>
                                    <p class="fs-16">Salary Received: <b class="text-primary">{{report.salaryReport.salaryReceived}}</b></p>
                                    <p class="fs-16">Status: <label
                                            class="label fs-16">{{report.salaryReport.confirmationStatusName}}</label></p>
                                    <p class="fs-16">Postponed: <span v-if="report.salaryReport.isPostponed">Yes</span> <span
                                            v-else="">No</span></p>
                                    <p class="fs-16">Submitted: <span v-if="report.salaryReport.isSubmittedForPayroll">Yes</span> <span
                                            v-else="">No</span></p>
                                </div>
                            </div>
                            <div class="col-lg-9 m-t-10">
                                <div class="card-block p-t-0">
                                    <h5 class="bold">Bonus/Cuts</h5>
                                    <div class="scrollable">
                                        <div style="height: 280px">
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
        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-if="isFetchingReportDetail">
            <!--Fetching data progress-->
            <div class="center-margin">
                <p class="text-center fs-21">Fetching Data.. Please wait..</p>
                <div class="progress h-8">
                    <div class="progress-bar-indeterminate progress-bar-success"></div>
                </div>
                <br>
            </div>
        </div>

    </div>

</template>
<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    export default{
        components: {},
        computed: {
            ...mapState('payroll', {
                isFetchingReportDetail: 'isFetchingReportDetail',
                salaryReportDetails: 'salaryReportDetails'
            })
        },
        created(){

        },
        mounted() {
            this.$store.dispatch({
                type: 'payroll/attemptGetSalaryReportDetail',
                id: this.$route.params.id
            })
        },
        methods:{
        }
    }
</script>