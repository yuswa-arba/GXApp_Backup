<template>
    <div class="modal  fade stick-up" id="modal-add-shipping-fee" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Shipping Fee</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card no-border">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12 m-t-10">
                                            <div class="form-group">
                                                <label> Include Shipping Fee </label>
                                                <select v-model="POFormObject.shippingFeeAdded"
                                                        class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <div class="form-group" v-if="parseInt(POFormObject.shippingFeeAdded)">
                                                <label> Price </label>
                                                <input type="number"
                                                       v-model="POFormObject.shippingFee"
                                                       class="form-control">
                                            </div>

                                        </div>

                                        <div class="col-lg-12 m-t-10">
                                            <button class="btn btn-primary pull-right" @click="finishEditing()">Finish
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
                POFormObject:'POFormObject'
            })
        },
        methods: {
            finishEditing(){
                let self = this

                $('#modal-add-shipping-fee').modal("toggle"); // close modal

            },

        },
    }
</script>