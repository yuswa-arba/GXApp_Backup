<template>
    <div class="modal  fade stick-up" id="modal-add-tax-fee" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Tax</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card no-border">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12 m-t-10">
                                            <label> Include 10% Tax </label>
                                            <select class="form-control"
                                                    @change="onTaxSelectChange()"
                                                    v-model="POFormObject.taxFeeAdded">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 m-t-10">
                                            <button class="btn btn-primary pull-right" @click="finishEditing()">Close
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
                POFormObject: 'POFormObject'
            })
        },

        methods: {
            onTaxSelectChange(){

                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                if(parseInt(purchaseOrderVuexState.POFormObject.taxFeeAdded)==1){
                    let price = 0

                    if (purchaseOrderVuexState.POItems.length > 0){
                        _.map(purchaseOrderVuexState.POItems, item => {
                            price = price + (item.amount * item.price)
                        })
                    }

                    // insert tax fee
                    purchaseOrderVuexState.POFormObject.taxFee = (price * 10 / 100)
                } else {
                    purchaseOrderVuexState.POFormObject.taxFee = 0
                }


            },
            finishEditing(){
                let self = this

                $('#modal-add-tax-fee').modal("toggle"); // close modal

            },

        },
    }
</script>