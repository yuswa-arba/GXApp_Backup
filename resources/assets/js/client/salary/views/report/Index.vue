<template>
    <div class="row">
        <div class="col-lg-5 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <form action="" id="generate-salary-form">
                        <h4>Generate Salary</h4>
                        <div class="form-group">
                            <label>Date Start - Date End </label>
                            <div class="input-daterange input-group" id="summary-datepicker-range">
                                <input type="text" class="input-sm form-control" name="generateFromDate" :value="defaultFromDate"/>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="input-sm form-control" name="generateToDate" :value="defaultToDate"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Branch Office</label>
                            <select class="form-control" v-model="selectedBranchOfficeId">
                                <option value="" disabled hidden selected> Select Branch Office</option>
                                <option :value="branchOffice.id" v-for="branchOffice in branchOffices">
                                    {{branchOffice.name}}
                                </option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary pull-right" @click="attemptGenerate()">Generate</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <h4>Log Details</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black fs-9" style="padding: 5px 5px">ID</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Employee</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Date</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Status</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Confirm Date</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Postponed</th>
                                <th class="text-black fs-9" style="padding: 5px 5px">Submitted</th>
                                <th class="text-black fs-9" style="padding: 5px 5px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="logDetail in salaryLogDetails">
                                <td>{{logDetail.id}}</td>
                                <td>{{logDetail.employeeName}}</td>
                                <td>{{logDetail.fromDate}} - {{logDetail.toDate}}</td>
                                <td>{{logDetail.confirmationStatusName}}</td>
                                <td>{{logDetail.confirmationDate}}</td>
                                <td>
                                    <span v-if="logDetail.isPostponed" class="bold text-danger">Yes</span>
                                    <span v-else="" class="bold text-primary">No</span>
                                </td>
                                <td>
                                    <!--is submiited for payroll-->
                                    <span v-if="logDetail.isSFP" class="bold text-primary">Yes</span>
                                    <span v-else="" class="bold text-danger">No</span>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-bordered">
                <div class="card-block">
                    <h4>Generate Logs</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black" >ID</th>
                                <th class="text-black" >Date</th>
                                <th class="text-black" >Branch</th>
                                <th class="text-black" >At/By</th>
                                <th class="text-black" ></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="salaryLog in generatedSalaryLogs">
                                <td>{{salaryLog.id}}</td>
                                <td>{{salaryLog.fromDate}} - {{salaryLog.toDate}}</td>
                                <td>{{salaryLog.branchOfficeName}}</td>
                                <td>{{salaryLog.generatedDate}} by {{salaryLog.generatedBy}}</td>
                                <td><i class="fa fa-info text-primary fs-16 cursor"></i></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>
<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    export default{
        data() {
            return{
                selectedBranchOfficeId:''
            }
        },
        computed: {
            ...mapState('report', {
                branchOffices: 'branchOffices',
                generatedSalaryLogs: 'generatedSalaryLogs',
                salaryLogDetails: 'salaryLogDetails',
            }),
            ...mapGetters('report',{
                defaultFromDate:'defaultFromDate',
                defaultToDate:'defaultToDate'
            })
        },
        created(){
            this.$store.dispatch('report/getDataOnCreate')
        },
        mounted: function () {
            $('#summary-datepicker-range').datepicker({format: 'dd/mm/yyyy', autoclose: true})
        },
        methods:{
            attemptGenerate(){
                let self  = this

                let fromDate = $('input[name="generateFromDate"]').val()
                let toDate = $('input[name="generateToDate"]').val()

                if(fromDate&&toDate&&self.selectedBranchOfficeId){

                    self.$store.dispatch({
                        type:'report/attemptGenerateSalaryData',
                        fromDate:fromDate,
                        toDate:toDate,
                        branchOfficeId:self.selectedBranchOfficeId
                    })
                    self.$router.push({name: 'attemptGenerate'})
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Something missing. Please check your generate form',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            }
        }
    }
</script>