<template>
    <div class="modal fade stick-up" id="modal-salary-queue-help" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Salary Queue Help</h5>
                </div>
                <div class="modal-body">
                    <p>Salary queue is simply a value that you want to add or subtract to/form someone's salary</p>
                    <p>
                        It is best use for one-time cases, such as postponed, special bonus, or anything that is not
                        routine
                    </p>
                    <p>
                        After you create salary queue, it will appear on the table below, but you can only delete it. To
                        actually use it, you will have to generate salary report in Report & Generate menu, the salary
                        queues can be previewed again before you generate the salary report.
                    </p>
                    <p class="bold">
                        All salary queues that exist will be automatically added/subtracted when you generate the salary report.
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
        methods:{
            closeModal(){
                $('#modal-salary-queue-help').modal('toggle')
            }
        }
    }
    </script>