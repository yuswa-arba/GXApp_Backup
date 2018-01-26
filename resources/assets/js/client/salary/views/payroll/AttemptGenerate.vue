<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="row" v-if="!isFetchingAttemptSalaryReportDate&&report.summary">
                        <div class="col-lg-6">
                            <button class="btn btn-outline-danger m-r-15 m-b-10 m-t-10 pull-left"
                                    @click="cancel()"><i class="fa fa-angle-left"></i> Go Back
                            </button>
                            <h4 class="pull-left">Generate Payroll ID: {{report.summary.id}}</h4>
                            <!--logs/history details-->
                        </div>
                        <div class="col-lg-6">
                            <div class="clearfix"></div>
                            <!--<div class="form-group" style="padding-top: 5px">-->
                            <!--<input type="text" id="search-salary-report-details"-->
                            <!--class="pull-right form-control"-->
                            <!--style="width: 250px" placeholder="Search">-->
                            <!--</div>-->
                            <div class="pull-right">
                                <button class="btn btn-primary m-r-15">Generate Valid Stage</button>
                                <button class="btn btn-info m-r-15">Generate Stage-1</button>
                            </div>

                            <!--TODO: ADD SORT BY BRANCH OFFICE-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8" v-if="!isFetchingAttemptSalaryReportDate && report.summary">
            <div class="card card-bordered filter-report-details no-padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-block">
                            <h5 class="bold">{{report.summary.fromDate}} - {{report.summary.toDate}}</h5>
                            <p class="fs-16">Branch: <b class="text-primary">{{report.summary.branchOfficeName}}</b></p>
                            <p class="fs-16">Generated: <b class="text-primary">@{{report.summary.generatedDate}}by {{report.summary.generatedBy}}</b></p>
                            <p class="fs-16">Total Reports: <b class="text-primary">{{report.summary.totalSalaryReport}}</b></p>
                            <p class="fs-16">Total Submitted: <b class="text-primary">{{report.summary.totalSubmittedForPayroll}}</b></p>
                            <p class="fs-16">Total Postponed: <b class="text-primary">{{report.summary.totalPostponed}}</b></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black fs-9"
                                            style="padding-top: 5px;padding-bottom: 5px">Status
                                        </th>
                                        <th class="text-black fs-9"
                                            style="padding-top: 5px;padding-bottom: 5px">Count
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Waiting for Confirmation</td>
                                        <td>{{report.summary.totalWaitingConfimation}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Confirmed</td>
                                        <td>{{report.summary.totalConfirmed}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Stage 1 Confirmed</td>
                                        <td>{{report.summary.totalStage1Confirmed}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Stage 2 Confirmed</td>
                                        <td>{{report.summary.totalStage2Confirmed}}</td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-if="isFetchingAttemptSalaryReportDate">
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
        mounted(){

        },
        created(){

        },
        computed: {
            ...mapState('payroll', {
                isFetchingAttemptSalaryReportDate :'isFetchingAttemptSalaryReportDate',
                report: 'attemptGenerateSalaryReport'
            })
        },
        methods: {
            cancel(){
                this.$router.go(-1)
            },

        }
    }
</script>