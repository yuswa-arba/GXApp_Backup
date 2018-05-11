<template>
    <div class="modal fade stick-up" id="modal-answer-leave-help" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Answering Leave Help</h5>
                </div>
                <div class="modal-body">
                    <p>
                        When selecting multiple leave requests, the system will review leave requests until the maximum limit of leave dates has been reached.
                    </p>
                    <p>
                        If you need to answer to specific leave request it is best to do it one by one to make sure that
                        is reviewed by the system. This is to make sure the admin does not approve the leave request more than the
                        max limit of each employee.
                    </p>
                    <p class="bold">
                        Note that the max limit only count from the "approved" leave request.
                    </p>
                </div>
                <div class="modal-footer">
                    <!--<div id="mf-role"></div>-->
                    <button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" @click="closeModal()">
                        Close
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-dialog -->

</template>
<script type="text/javascript">
    export default{
        methods: {
            closeModal(){
                $('#modal-answer-leave-help').modal('toggle')
            }
        }
    }
</script>