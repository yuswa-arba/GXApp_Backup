<template>
    <div class="modal fade stick-up" id="modal-attempt-send-to-managers" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Send to managers</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group required">
                                <label>Due Date</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input id="duedate" type="text" class="form-control" name="dueDate"
                                           required>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-20 pull-right" @click="sendToManagers()">
                                Send
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

            }
        },
        mounted: function () {
            let d = new Date();
            $('#duedate').datepicker({
                format: 'dd/mm/yyyy',
                autoclose:true
            });
        },
        computed:{

        },
        methods: {
            sendToManagers(){

                let self = this
                let dueDate = $('#duedate').val()

                if(dueDate){
                    this.$store.dispatch({
                        type:'timesheet/sendSummaryToManagers',
                        dueDate:dueDate
                    })
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Due date cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            }
        }

    }
</script>