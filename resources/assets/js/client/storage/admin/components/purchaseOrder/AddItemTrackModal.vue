<template>
    <div class="modal  fade stick-up" id="modal-add-item-track" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Add Track</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card no-border">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12 m-t-10">

                                            <div class="form-group">
                                                <label> Estimated Date Arrival </label>
                                                <input type="text"
                                                       class="form-control"
                                                       :value="itemToAddTrack.estimatedDateArrival"
                                                       placeholder="e.g 12/01/2018"
                                                       id="estimated-date-arrival">
                                            </div>
                                            <div class="form-group">
                                                <label> Estimated Time Arrival </label>

                                                <div class="input-group bootstrap-timepicker">
                                                    <input type="text"
                                                           class="form-control"
                                                           :value="itemToAddTrack.estimatedTimeArrival"
                                                           id="estimated-time-arrival"
                                                           placeholder="e.g 08:00 ">
                                                    <span class="input-group-addon"><i class="pg-clock"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label> Notes </label>
                                                <input type="text"
                                                       id="item-track-notes"
                                                       :value="itemToAddTrack.notes"
                                                       class="form-control">
                                            </div>


                                        </div>

                                        <div class="col-lg-12 m-t-10">
                                            <button class="btn btn-primary pull-right" @click="addItemTrack()">Add Track
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

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
    import series from 'async/series';
    export default{
        data(){
            return {
            }
        },
        mounted(){
            $('#estimated-time-arrival').timepicker({showMeridian: false}).on('show.timepicker', function (e) {
                let widget = $('.bootstrap-timepicker-widget');
                widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
                widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
            });
            $('#estimated-date-arrival').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true});
        },
        created(){
        },
        computed: {
            ...mapState('purchaseOrder', {
                itemToAddTrack: 'itemToAddTrack'
            })
        },
        methods: {
            closeModal(){
                $('#modal-add-item-track').modal('toggle')
            },
            finishEditing(){
                let self = this

                $('#modal-add-item-track').modal("toggle"); // close modal

            },
            addItemTrack(){

                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                let self = this
                series([
                    function (cb) {
                        purchaseOrderVuexState.itemToAddTrack.estimatedDateArrival = $('#estimated-date-arrival').val()
                        purchaseOrderVuexState.itemToAddTrack.estimatedTimeArrival = $('#estimated-time-arrival').val()
                        purchaseOrderVuexState.itemToAddTrack.notes = $('#item-track-notes').val()

                        cb(null, '')
                    },
                    function (cb) {
                        if (purchaseOrderVuexState.itemToAddTrack.estimatedDateArrival != ''
                            && purchaseOrderVuexState.itemToAddTrack.estimatedTimeArrival) {
                            self.$store.commit({
                                type: 'purchaseOrder/addItemTrack',
                            })
                        } else {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: 'Estimated date and time cannot be empty',
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        }
                        cb(null, '')
                    }
                ])


            }

        },
    }
</script>