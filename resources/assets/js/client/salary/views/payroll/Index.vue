<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="pull-left" v-if="lastGeneratedPayroll.id">
                        <h5 class="m-t-0">Last Generated Payroll at {{lastGeneratedPayroll.generatedDate}} by
                            {{lastGeneratedPayroll.generatedBy}}</h5>
                        <span class="help">(ID: {{lastGeneratedPayroll.id}}, Date: {{lastGeneratedPayroll.fromDate}} - {{lastGeneratedPayroll.toDate}}, Branch: {{lastGeneratedPayroll.branchOfficeName}} ,Total Employee: {{lastGeneratedPayroll.totalEmployee}}) </span>
                    </div>

                    <button class="btn btn-primary pull-right" @click="startGeneratePayroll()">Start Generate Payroll <i
                            class="fa fa-angle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-bordered">
                <div class="card-block">
                    <h4>Generated Payroll List</h4>
                    <div class="scrollable">
                        <div style="height: 500px">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black p-t-5 p-b-5">ID</th>
                                        <th class="text-black p-t-5 p-b-5">Date</th>
                                        <th class="text-black p-t-5 p-b-5">Branch Office</th>
                                        <th class="text-black p-t-5 p-b-5">Generated</th>
                                        <th class="text-black p-t-5 p-b-5">Employee</th>
                                        <th class="text-black p-t-5 p-b-5" style="width: 250px">Notes</th>
                                        <th class="text-black p-t-5 p-b-5" style="width: 300px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(payroll,index) in generatedPayrollList">
                                        <td>{{payroll.id}}</td>
                                        <td>{{payroll.fromDate}} - {{payroll.toDate}}</td>
                                        <td>{{payroll.branchOfficeName}}</td>
                                        <td>@{{payroll.generatedDate}} by {{payroll.generatedBy}} Type:
                                            {{payroll.generatedType}}
                                        </td>
                                        <td>{{payroll.totalEmployee}}</td>
                                        <td>{{payroll.notes}}</td>
                                        <td>
                                            <div v-if="payroll.file">
                                                <button class="btn btn-outline-primary" @click="downloadFile(payroll.id)"><i class="fa fa-arrow-down"></i> Download File</button>
                                                &nbsp;
                                                <button class="btn btn-outline-danger" @click="deleteFile(payroll.id,index)"><i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                            <p v-else="">No File</p>

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
</template>
<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    export default{
        components: {},
        mounted(){

        },
        created(){
            this.$store.dispatch('payroll/getDataOnCreate')
        },
        computed: {
            ...mapState('payroll', {
                lastGeneratedPayroll: 'lastGeneratedPayroll',
                generatedPayrollList: 'generatedPayrollList'
            })
        },
        methods: {
            startGeneratePayroll(){
                this.$router.push({name: 'salaryReportList'})
            },
            downloadFile(id){
                this.$store.commit({
                    type:'payroll/downloadFile',
                    id:id
                })
            },
            deleteFile(id,index){
                this.$store.commit({
                    type:'payroll/deleteFile',
                    id:id,
                    index:index
                })
            }
        }
    }
</script>