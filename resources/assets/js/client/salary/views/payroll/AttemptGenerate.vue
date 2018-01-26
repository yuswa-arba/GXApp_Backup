<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="row" v-if="!isFetchingAttemptSalaryReportData&&report.summary">
                        <div class="col-lg-6">
                            <button class="btn btn-outline-danger m-r-15 m-b-10 m-t-10 pull-left"
                                    @click="cancel()"><i class="fa fa-times"></i> Cancel
                            </button>
                            <h4 class="pull-left"><b>Generate Payroll</b> (Generated Salary Report ID: {{report.summary.id}})</h4>
                            <!--logs/history details-->
                        </div>
                        <div class="col-lg-6">
                            <div class="clearfix"></div>
                            <div class="pull-right">
                                <button class="btn btn-primary m-r-15" v-if="report.availability.normal" @click="startGeneratePayrollModal('confirmed')">Generate Valid
                                    Stage
                                </button>
                                <button class="btn btn-primary m-r-15" disabled v-else="">Generate Valid Stage</button>

                                <button class="btn btn-info m-r-15" v-if="report.availability.stage1" @click="startGeneratePayrollModal('stage-1-confirmed')">Generate Stage-1
                                </button>
                                <button class="btn btn-info m-r-15" disabled v-else=""> Generate Stage-1</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8" v-if="!isFetchingAttemptSalaryReportData && report.summary">
            <div class="card card-bordered filter-report-details no-padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-block">
                            <h5 class="bold">{{report.summary.fromDate}} - {{report.summary.toDate}}</h5>
                            <p class="fs-16">Branch: <b class="text-primary">{{report.summary.branchOfficeName}}</b></p>
                            <p class="fs-16">Generated: <b class="text-primary">@{{report.summary.generatedDate}}by
                                {{report.summary.generatedBy}}</b></p>
                            <p class="fs-16">Total Reports: <b
                                    class="text-primary">{{report.summary.totalSalaryReport}}</b></p>
                            <p class="fs-16">Total Submitted: <b class="text-primary">{{report.summary.totalSubmittedForPayroll}}</b>
                            </p>
                            <p class="fs-16">Total Postponed: <b
                                    class="text-primary">{{report.summary.totalPostponed}}</b></p>
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
        <div class="col-lg-4">
            <div v-if="report.availability">
                <div class="card card-bordered" v-if="report.availability.normalExisted.isExist||report.availability.stage1Existed.isExist">
                    <div class="card-block">
                        <div class="alert alert-warning bordered m-b-0">

                            <p><i class="fa fa-info-circle"></i> This report has been generated before</p>

                            <div class="row">
                                <div class="col-lg-6" v-if="report.availability.normalExisted.isExist">
                                    <h5 class="bold">Valid Stage</h5>
                                    <p v-if="report.availability.normalExisted.payrollId!=''">ID: {{report.availability.normalExisted.payrollId}}</p>
                                    <p v-if="report.availability.normalExisted.generatedDate!=''">Date: {{report.availability.normalExisted.generatedDate}}</p>
                                    <p v-if="report.availability.normalExisted.generatedBy!=''">By: {{report.availability.normalExisted.generatedBy}}</p>
                                </div>
                                <div class="col-lg-6" v-if="report.availability.stage1Existed.isExist">
                                    <h5 class="bold">Stage-1</h5>
                                    <p v-if="report.availability.stage1Existed.payrollId!=''">ID: {{report.availability.stage1Existed.payrollId}}</p>
                                    <p v-if="report.availability.stage1Existed.generatedDate!=''">Date: {{report.availability.stage1Existed.generatedDate}}</p>
                                    <p v-if="report.availability.stage1Existed.generatedBy!=''">By: {{report.availability.stage1Existed.generatedBy}}</p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-block">
                    <h5><i class="fa fa-circle text-info"></i> Waiting For Confirmation</h5>
                    <div class="scrollable">
                        <div style="height: 400px">
                            <div class="table-responsive" v-if="report.details">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Division</th>
                                        <th>Branch</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="report.details.waiting">
                                    <tr v-for="data in report.details.waiting">
                                        <td>{{data.id}}</td>
                                        <td>{{data.employeeName}}</td>
                                        <td>{{data.divisionName}}</td>
                                        <td>{{data.branchOfficeName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-block">
                    <h5><i class="fa fa-circle text-success"></i> Confirmed</h5>
                    <div class="scrollable">
                        <div style="height: 400px">
                            <div class="table-responsive" v-if="report.details">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Division</th>
                                        <th>Branch</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="report.details.confirmed">
                                    <tr v-for="data in report.details.confirmed">
                                        <td>{{data.id}}</td>
                                        <td>{{data.employeeName}}</td>
                                        <td>{{data.divisionName}}</td>
                                        <td>{{data.branchOfficeName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-block">
                    <h5><i class="fa fa-circle text-warning"></i> Stage 1 Confirmed</h5>
                    <div class="scrollable">
                        <div style="height: 400px">
                            <div class="table-responsive" v-if="report.details">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Division</th>
                                        <th>Branch</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="report.details.stage1Confirmed">
                                    <tr v-for="data in report.details.stage1Confirmed">
                                        <td>{{data.id}}</td>
                                        <td>{{data.employeeName}}</td>
                                        <td>{{data.divisionName}}</td>
                                        <td>{{data.branchOfficeName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-block">
                    <h5><i class="fa fa-circle text-danger"></i> Stage 2 Confirmed</h5>
                    <div class="scrollable">
                        <div style="height: 400px">
                            <div class="table-responsive" v-if="report.details">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Division</th>
                                        <th>Branch</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="report.details.stage2Confirmed">
                                    <tr v-for="data in report.details.stage2Confirmed">
                                        <td>{{data.id}}</td>
                                        <td>{{data.employeeName}}</td>
                                        <td>{{data.divisionName}}</td>
                                        <td>{{data.branchOfficeName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-block">
                    <h5><i class="fa fa-circle text-true-black"></i> Unconfirmed</h5>
                    <div class="scrollable">
                        <div style="height: 400px">
                            <div class="table-responsive" v-if="report.details">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Division</th>
                                        <th>Branch</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="report.details.unconfirmed">
                                    <tr v-for="data in report.details.unconfirmed">
                                        <td>{{data.id}}</td>
                                        <td>{{data.employeeName}}</td>
                                        <td>{{data.divisionName}}</td>
                                        <td>{{data.branchOfficeName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-if="isFetchingAttemptSalaryReportData">
            <!--Fetching data progress-->
            <div class="center-margin">
                <p class="text-center fs-21">Fetching Data.. Please wait..</p>
                <div class="progress h-8">
                    <div class="progress-bar-indeterminate progress-bar-success"></div>
                </div>
                <br>
            </div>
        </div>
        <start-generate-payroll-modal></start-generate-payroll-modal>
    </div>
</template>
<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    import StartGeneratePayrollModal from '../../components/payroll/StartGeneratePayrollModal.vue'
    export default{
        components: {
            'start-generate-payroll-modal':StartGeneratePayrollModal
        },
        mounted(){

        },
        created(){
            this.$store.dispatch({
                type: 'payroll/attemptGeneratePayroll',
                generateSalaryReportLogId: this.$route.params.id
            })
        },
        computed: {
            ...mapState('payroll', {
                isFetchingAttemptSalaryReportData: 'isFetchingAttemptSalaryReportData',
                report: 'attemptGenerateSalaryReport'
            })
        },
        methods: {
            cancel(){
                this.$router.go(-1)
            },
            startGeneratePayrollModal(type){
                this.$store.state.payroll.attemptGenerateType = type

                $('#modal-start-generate-payroll').modal('show') //show modal
            }
        }
    }
</script>