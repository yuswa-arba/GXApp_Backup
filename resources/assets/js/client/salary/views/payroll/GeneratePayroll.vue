<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 p-t-200" v-if="isStartGeneratingPayroll">
            <!--Fetching data progress-->
            <div class="center-margin">
                <p class="text-center fs-21">Generating Payroll.. Please wait..</p>
                <div class="progress h-8">
                    <div class="progress-bar-indeterminate progress-bar-success"></div>
                </div>
                <br>
            </div>
        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-if="!isStartGeneratingPayroll">

            <!--success response-->
            <div class="center-margin text-center" v-if="!generatePayrollResponse.isFailed">
                <div class="alert alert-info">
                    <h4>{{generatePayrollResponse.message}}</h4>
                    <div style="padding:20px">
                        <button class="btn btn-primary" @click="downloadFile(generatedPayrollId)">Download</button>
                        <button class="btn btn-outline-primary" @click="finish()">Finish</button>
                    </div>

                </div>
            </div>

            <!--error response-->
            <div class="center-margin text-center" v-else="">
                <div class="alert alert-danger">
                    <h4>{{generatePayrollResponse.message}}</h4>
                    <div style="padding:20px">
                        <button class="btn btn-outline-danger" @click="finish()">Finish</button>
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

        },
        computed: {
            ...mapState('payroll', {
                isStartGeneratingPayroll: 'isStartGeneratingPayroll',
                generatedPayrollId: 'generatedPayrollId',
                generatePayrollResponse:'generatePayrollResponse'
            })
        },
        methods: {
            finish(){
                this.$router.push('/')
            },
            downloadFile(id){
                this.$store.commit({
                    type:'payroll/downloadFile',
                    id:id
                })
            }
        }
    }
</script>