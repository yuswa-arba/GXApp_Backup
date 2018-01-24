<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-6 m-b-10" v-if="!isFetchingSalaryData">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="row" v-if="attemptGenerateSalaryData.summary">
                        <div class="col-lg-6">
                            <p class="fs-21">Total Employees :
                                <b>{{attemptGenerateSalaryData.summary.totalEmployees}}</b></p>
                            <p class="fs-21">Branch Office :
                                <b>{{attemptGenerateSalaryData.summary.branchOfficeName}}</b></p>
                        </div>
                        <div class="col-lg-6">
                            <p class="fs-21">From Date : <b>{{attemptGenerateSalaryData.summary.fromDate}}</b></p>
                            <p class="fs-21">To Date : <b>{{attemptGenerateSalaryData.summary.toDate}}</b></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6 m-b-10" v-if="!isFetchingSalaryData">
            <div class="alert alert-info bordered m-b-0">
                <div class="row">
                    <div class="col-lg-7">
                        <h3><strong><i class="fa fa-warning"></i> Generate Now ?</strong></h3>
                    </div>
                    <div class="col-lg-5">
                        <div class="center-margin">
                            <h3>
                                <button class="btn btn-outline-danger" @click="cancelGenerate()"><i class="fa fa-times"></i> No</button>
                                <button class="btn btn-outline-primary"
                                        @click="generateSalaryReports(
                                        attemptGenerateSalaryData.summary.fromDate,
                                        attemptGenerateSalaryData.summary.toDate,
                                        attemptGenerateSalaryData.summary.branchOfficeId)">
                                    <i class="fa fa-check" ></i> Yes
                                </button>
                            </h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 m-b-10" v-if="attemptGenerateSalaryData.employeesSalaryReport">
            <div class="filter-item card card-bordered" v-for="report in attemptGenerateSalaryData.employeesSalaryReport">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block bg-primary" style="padding:3px 15px!important;">
                        <div class="pull-left">
                            <span class="text-white fs-16 bold">{{report.employeeName}}</span>
                            <span class="text-white fs-16">({{report.employeeNo}})</span>
                        </div>
                        <div class="pull-right">
                            <span class="text-white fs-14 bold">{{report.divisionName}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2" v-if="report.timesheetSummary">
                        <div class="card-block">
                            <h5 class="bold">Timesheet Summary</h5>
                            <p class="fs-16">Total Days of Absence : <b class="text-primary">{{report.timesheetSummary.totalDayAbsence}}</b></p>
                            <p class="fs-16">Total Min. Late: <b class="text-primary">{{report.timesheetSummary.totalMinLate}}</b></p>
                            <p class="fs-16">Total Min. Early Out : <b class="text-primary">{{report.timesheetSummary.totalMinEarlyOut}}</b></p>
                        </div>
                    </div>

                    <div class="col-lg-2" v-if="report.salarySummary">
                        <div class="card-block">
                            <h5 class="bold">Salary Summary</h5>
                            <p class="fs-16">Basic Salary: <b class="text-primary">{{report.salarySummary.basicSalary}}</b></p>
                            <p class="fs-16">Total Bonus: <b class="text-primary">{{report.salarySummary.totalBonus}}</b></p>
                            <p class="fs-16">Total Cut: <b class="text-primary">{{report.salarySummary.totalCut}}</b></p>
                            <p class="fs-16">Salary Received: <b class="text-primary">{{report.salarySummary.salaryReceived}}</b></p>
                        </div>
                    </div>

                    <div class="col-lg-4" v-if="report.generalBonusCut">
                        <div class="card-block bordered">
                            <h5 class="bold">General Bonus/Cut</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>Name</th>
                                        <th>Add/Sub</th>
                                        <th>Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="gbc in report.generalBonusCut">
                                        <td>{{gbc.name}}</td>
                                        <td>
                                            <label v-if="gbc.addOrSub=='add'" class="label label-success">{{gbc.addOrSub}}</label>
                                            <label v-else="" class="label label-danger">{{gbc.addOrSub}}</label>
                                        </td>
                                        <td>{{gbc.value}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4" v-if="report.employeeBonusCut">
                        <div class="card-block bordered">
                            <h5 class="bold">Employee Bonus/Cut</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>Name</th>
                                        <th>Add/Sub</th>
                                        <th>Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="ebc in report.employeeBonusCut">
                                        <td>{{ebc.name}}</td>
                                        <td>
                                            <label v-if="ebc.addOrSub=='add'" class="label label-success">{{ebc.addOrSub}}</label>
                                            <label v-else="" class="label label-danger">{{ebc.addOrSub}}</label>
                                        </td>
                                        <td>{{ebc.value}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-if="isFetchingSalaryData">
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
            ...mapState('report', {
                isFetchingSalaryData: 'isFetchingSalaryData',
                attemptGenerateSalaryData: 'attemptGenerateSalaryData'
            })
        },
        created(){

        },
        mounted: function () {

        },
        methods:{
            generateSalaryReports(fromDate,toDate,branchOfficeId){

                let self = this

                if(fromDate&&toDate&&branchOfficeId){

                    self.$store.dispatch({
                        type:'report/generateSalary',
                        fromDate:fromDate,
                        toDate:toDate,
                        branchOfficeId:branchOfficeId
                    })

                    self.$router.push({name: 'generateSalary'})

                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Something is missing. Unable to generate salary',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            },
            cancelGenerate(){
                this.$router.go(-1)
            }
        }
    }
</script>