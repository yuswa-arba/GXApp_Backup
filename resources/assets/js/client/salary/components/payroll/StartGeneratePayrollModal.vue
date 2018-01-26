<template>
    <div class="modal fade stick-up" id="modal-start-generate-payroll" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Start Generate Payroll</h5>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Type: {{attemptGenerateType}}</p>
                                <div class="form-group">
                                    <label>Transfer Date </label>
                                    <input id="transferDate" type="text" class="form-control" name="transferDate" required>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <input type="text" v-model="notes" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" @click="generatePayrollNow()">
                                Generate
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-dialog -->


</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default{
        data(){
            return{
                notes:''
            }
        },
        mounted:function(){
            $('#transferDate').datepicker({
                autoclose:true,
                format: 'dd/mm/yyyy',
                todayHighlight:true
            });

            let transferDate = moment().format('DD/MM/YYYY')
            $('#transferDate').val(transferDate)
        },
        computed:{
            ...mapState('payroll',{
                attemptGenerateType:'attemptGenerateType'
            })
        },
        methods: {
            generatePayrollNow(){
                let self = this
                let transferDate = $('#transferDate').val()

                if(transferDate&&self.notes){

                    this.$store.dispatch({
                        type:'payroll/startGeneratePayroll',
                        generateSalaryReportLogId:this.$route.params.id,
                        transferDate:transferDate,
                        notes:self.notes
                    })

                    this.$router.push({name:'generate',params:{id:this.$route.params.id}})

                } else {
                     $('.page-container').pgNotification({
                          style: 'flip',
                          message: 'Error! Form is invalid',
                          position: 'top-right',
                          timeout: 3500,
                          type: 'danger'
                      }).show();
                }

            }
        }

    }
</script>