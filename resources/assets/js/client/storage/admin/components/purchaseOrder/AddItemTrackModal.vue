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
                                                       id="estimated-date-arrival"
                                                       v-model="itemToAddTrack.estimatedDateArrival">
                                            </div>
                                            <div class="form-group">
                                                <label> Estimated Time Arrival </label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="estimated-time-arrival"
                                                       v-model="itemToAddTrack.estimatedTimeArrival">
                                            </div>
                                            <div class="form-group">
                                                <label> Notes </label>
                                                <input type="number"
                                                       v-model="itemToAddTrack.notes"
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
    export default{
        data(){
            return {}
        },
        mounted(){

        },
        computed: {
            ...mapState('purchaseOrder', {
                itemToAddTrack: 'itemToAddTrack'
            })
        },
        methods: {
            finishEditing(){
                let self = this

                $('#modal-add-item-track').modal("toggle"); // close modal

            },
            addItemTrack(){

                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                if (purchaseOrderVuexState.estimatedDateArrival != ''
                    && purchaseOrderVuexState.estimatedTimeArrival) {
                    this.$store.commit({
                        type: 'purchaseOrder/addItemTrack',
                    })
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message:'Estimated date and time cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            }

        },
    }
</script>