<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-6 m-b-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="fs-21">Total Employees :
                                <b>{{lastPayrollDetail.totalEmployee}}</b></p>
                            <p class="fs-21">Branch Office :
                                <b>{{lastPayrollDetail.branchOfficeName}}</b></p>
                        </div>
                        <div class="col-lg-6">
                            <p class="fs-21">From Date : <b>{{lastPayrollDetail.fromDate}}</b></p>
                            <p class="fs-21">To Date : <b>{{lastPayrollDetail.toDate}}</b></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="fs-16"> Generated at <span class="bold text-primary">{{lastPayrollDetail.generatedDate}}</span> by <span class="text-primary bold">{{lastPayrollDetail.generatedBy}}</span> with type <span class="text-primary bold">{{lastPayrollDetail.generatedType}}</span> </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="fs-16">Notes: {{lastPayrollDetail.notes}}</p>
                        </div>
                        <div class="col-lg-6">
                            <div v-if="lastPayrollDetail.file">
                                <button class="btn btn-outline-primary" @click="downloadFile(lastPayrollDetail.id)"><i class="fa fa-arrow-down"></i> Download File</button>
                                &nbsp;
                                <button class="btn btn-outline-danger" @click="deleteFile(lastPayrollDetail.id,0)"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                            <p v-else="">No File</p>
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
            this.$store.commit({
                type:'payroll/getLastPayrollDetail',
                id:this.$route.params.id
            })
        },
        computed: {
            ...mapState('payroll', {
                lastPayrollDetail: 'lastPayrollDetail',
            })
        },
        methods: {
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