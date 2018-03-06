<template>
    <div class="row">
        <div class="col-lg-12 m-t-20">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px">
                    <div class="row">
                        <div class="col-lg-4"><p class="text-black fs-16 p-t-10">Item</p></div>
                        <div class="col-lg-2"><p class="text-black fs-16 p-t-10">Amount</p></div>
                        <div class="col-lg-1"><p class="text-black fs-16 p-t-10">Unit</p></div>
                        <div class="col-lg-3"><p class="text-black fs-16 p-t-10">Notes</p></div>
                        <div class="col-lg-2">
                            <p class="text-black fs-24 m-t-10"> Total: {{itemsBeingRequested.length}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--items in cart-->
        <div class="col-lg-12">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px" v-if="itemsBeingRequested.length>0">
                    <div class="col-lg-12" v-for="(item,index) in itemsBeingRequested">
                        <div class="row">
                            <div class="col-lg-4 p-t-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="cursor" @click="viewImage('/images/storage/items/'+item.itemPhoto)">
                                            <img :src="'/images/storage/items/'+item.itemPhoto" height="60px" alt="No Image Found">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-black fs-16 m-b-0">{{item.itemName}}</p>
                                        <p class="no-padding fs-14">{{item.itemCode}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 p-t-10">
                                <p class="text-black fs-16 m-b-0">{{item.amount}}</p>
                            </div>
                            <div class="col-lg-1 p-t-10"><p class="text-black fs-16 p-t-10">{{item.itemUnit}}</p></div>
                            <div class="col-lg-3 p-t-10">
                                <p class="text-black fs-16 m-b-0">{{item.notes}}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                </div>
                <div class="card-block" v-else="">
                    <h4 class="text-center">Your cart is empty</h4>
                </div>
            </div>
        </div>
        <!--end of items in cart-->

        <!--requisition form-->
        <div class="col-lg-12">
            <div class="card card-default card-bordered">
                <div class="card-header">
                    <div class="card-title">
                        Requisition Form
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label> Division </label>
                                <select class="form-control" v-model="requisitionForm.divisionId">
                                    <option value="" selected disabled hidden>Select Division</option>
                                    <option :value="division.id" v-for="division in divisions">{{division.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label> Delivery Warehouse </label>
                                <select class="form-control" v-model="requisitionForm.deliveryWarehouseId">
                                    <option value="" selected disabled hidden>Select Delivery Warehouse</option>
                                    <option :value="warehouse.id" v-for="warehouse in deliveryWarehouses">
                                        {{warehouse.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Date Needed By</label>
                                <input type="text"
                                       id="date-needed-by"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Description </label>
                                <input type="text"
                                       class="form-control"
                                       v-model="requisitionForm.description"
                                >
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button class="btn btn-lg btn-primary fs-18 pull-right"
                                    v-if="!isSubmittingRequisition"
                                    @click="sendRequisition()">
                                Send Requisition
                            </button>
                            <button class="btn btn-disabled fs-18 pull-right" v-else="" disabled>
                                Submitting.. Please wait..
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!--end of requisition form-->

</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {}
        },
        created(){

        },
        mounted: function () {
            $('#date-needed-by').datepicker({format: 'dd/mm/yyyy', autoclose: true,todayHighlight:true})
        },
        computed: {
            ...mapState('cart', {
                itemsBeingRequested: 'itemsBeingRequested',
                requisitionForm: 'requisitionForm',
                deliveryWarehouses: 'deliveryWarehouses',
                divisions: 'divisions',
                isSubmittingRequisition:'isSubmittingRequisition'
            })
        },
        methods: {
            viewImage(url){
                window.open(url, '_blank')
            },
            sendRequisition(){

                let cartVuexState = this.$store.state.cart

                //insert date needed by
                cartVuexState.requisitionForm.dateNeededBy = $('#date-needed-by').val()

                //insert itemCartIds to form
                cartVuexState.requisitionForm.itemCartIds = cartVuexState.selectedItemsIdToRequest

                setTimeout(()=>{

                    if( cartVuexState.requisitionForm.itemCartIds.length>0
                        && cartVuexState.requisitionForm.divisionId != null
                        && cartVuexState.requisitionForm.deliveryWarehouseId != null
                        && cartVuexState.requisitionForm.dateNeededBy != null
                        && cartVuexState.requisitionForm.divisionId != ''
                        && cartVuexState.requisitionForm.deliveryWarehouseId != ''
                        && cartVuexState.requisitionForm.dateNeededBy != ''
                    ) {

                        cartVuexState.isSubmittingRequisition=true

                        this.$store.commit({
                            type:'cart/createRequisition'
                        })

                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: "Form is invalid. Please check your requisition form",
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }

                },300)


            }

        }
    }
</script>