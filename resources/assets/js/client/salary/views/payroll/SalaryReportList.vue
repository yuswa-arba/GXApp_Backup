<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 m-b-10 m-t-10">
                    <div class="card card-bordered">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button class="btn btn-outline-primary m-r-15 m-b-10 m-t-10 pull-left"
                                            @click="goBack()"><i class="fa fa-angle-left"></i> Go Back
                                    </button>
                                    <h4 class="pull-left">Salary Report History</h4>
                                    <!--logs/history details-->
                                </div>
                                <div class="col-lg-6">
                                    <div class="clearfix"></div>
                                    <!--<div class="form-group" style="padding-top: 5px">-->
                                    <!--<input type="text" id="search-salary-report-details"-->
                                    <!--class="pull-right form-control"-->
                                    <!--style="width: 250px" placeholder="Search">-->
                                    <!--</div>-->
                                    <div class="pull-right m-r-15">
                                        <div class="form-group required">
                                            <div class="input-group bootstrap-timepicker">
                                                <input id="sortReportListYear" name="sortReportListYear" type="text"
                                                       class="form-control" required>
                                                <span class="input-group-addon bg-primary text-white"
                                                      @click="sortReportList()"><i
                                                        class="fa fa-check"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!--TODO: ADD SORT BY BRANCH OFFICE-->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-bordered filter-report-details no-padding"
                         v-for="(report,index) in salaryReportsHistory">
                        <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                            <div class="card-block bg-master" style="padding:3px 15px!important;">
                                <div class="pull-left">
                                    <span class="text-white fs-16 bold">ID: {{report.id}}</span>
                                </div>
                                <div class="pull-right">
                                    <span class="text-white fs-14 bold">{{report.fromDate}} - {{report.toDate}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card-block">
                                    <p class="fs-16">Branch: <b
                                            class="text-primary">{{report.branchOfficeName}}</b></p>
                                    <p class="fs-16">Generated: <b class="text-primary">@{{report.generatedDate}}
                                        by {{report.generatedBy}}</b></p>
                                    <p class="fs-16">Total Reports: <b
                                            class="text-primary">{{report.totalSalaryReport}}</b>
                                    </p>
                                    <p class="fs-16">Total Submitted: <b class="text-primary">{{report.totalSubmittedForPayroll}}</b>
                                    </p>
                                    <p class="fs-16">Total Postponed: <b
                                            class="text-primary">{{report.totalPostponed}}</b>
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-4">
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
                                                <td>{{report.totalWaitingConfimation}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Confirmed</td>
                                                <td>{{report.totalConfirmed}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Stage 1 Confirmed</td>
                                                <td>{{report.totalStage1Confirmed}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Stage 2 Confirmed</td>
                                                <td>{{report.totalStage2Confirmed}}</td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-block">
                                    <button class="btn btn-info m-b-10" @click="showDetail(report.id)"><i
                                            class="fa fa-eye"></i> View Details
                                    </button>
                                    <br>
                                    <button class="btn btn-primary m-b-10" @click="attemptGenerate(report.id)"><i class="fa fa-print" ></i> Generate Payroll
                                    </button>
                                    <br>
                                    <button class="btn btn-complete m-b-10" @click="refresh(report.id,index)"><i
                                            class="fa fa-refresh"></i> Refresh
                                    </button>
                                    <br>
                                    <button class="btn btn-danger m-b-10" v-if="report.isGeneratedForPayroll" @click="viewLastPayroll(report.id)"><i class="fa fa-eye"></i> View Last Payroll
                                    </button>
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
    import {mapGetters, mapState} from 'vuex'
    export default{
        components: {},
        mounted(){
            $('#sortReportListYear').datepicker({
                autoclose: true,
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years"
            });

            let currentYear = moment().format('YYYY')
            if (this.$store.state.payroll.selectedYear) {
                currentYear = this.$store.state.payroll.selectedYear
            }
            $('#sortReportListYear').val(currentYear)
        },
        created(){
            this.$store.dispatch('payroll/getSalaryReportList')
        },
        computed: {
            ...mapState('payroll', {
                salaryReportsHistory: 'salaryReportsHistory'
            })
        },
        methods: {
            goBack(){
                this.$router.go(-1)
            },
            showDetail(id){
                this.$router.push({name: 'salaryReportDetail', params: {id: id}})
            },
            refresh(id, index){

                this.$store.commit({
                    type: 'payroll/refreshSalaryReport',
                    id: id,
                    index: index
                })
            },
            attemptGenerate(id){

                this.$router.push({name: 'attemptGenerate',params:{id:id}})

            },
            viewLastPayroll(id){
              this.$router.push({name:'lastPayrollDetail',params:{id:id}})
            },
            sortReportList(){

                let selectedYear = $('input[name="sortReportListYear"]').val()

                this.$store.dispatch({
                    type:'payroll/sortReportList',
                    selectedYear: selectedYear
                })

            }
        }
    }
</script>