<template>

    <div class="col-lg-8">
        <div class="card card-default">

            <!--<div class="card card-default" v-if="POFormIsFinishAndValid">-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default no-border">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-info pull-right" @click="attemptAddItemModal()">Add Item <i
                                            class="fa fa-plus"></i></button>
                                </div>
                                <div class="col-lg-12 p-t-10 border-bottom-grey select-hover-warning"
                                     v-for="(item,index) in POItems">
                                    <div class="row">
                                        <div class="col-lg-2 m-t-5">
                                            <p class="m-b-0 fs-16"> Amount : <span
                                                    class="text-black">{{item.amount}}</span></p>
                                            <p class="m-b-0 fs-16" v-if="item.hasCustomUnit"> Unit :
                                                {{item.customUnit}}</p>
                                            <p class="m-b-0 fs-16" v-else="">Unit : {{item.unitFormat}}</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="text-black fs-16 m-b-0 bold">{{item.itemDetail.name}}</p>
                                            <p class="m-b-10">{{item.itemDetail.itemCode}}</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="m-b-0">per item</p>
                                            <p class="text-black m-b-10 fs-16">{{item.currencyFormat}}
                                                {{formatPrice(item.price)}}</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="m-b-0">sub total</p>
                                            <p class="text-black m-b-10 fs-16 bold">{{item.currencyFormat}}
                                                {{formatPrice(item.price*item.amount)}}</p>
                                        </div>
                                        <div class="col-lg-1 m-t-5">
                                            <p><i class="fa fa-trash text-hover-danger fs-16 cursor m-t-10"
                                                  @click="removeItemFromPO(item.id,index)"></i></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 border-bottom-grey"
                                     style="padding-top: 20px; padding-bottom: 20px">
                                    <div class="row">

                                        <div class="col-lg-6 m-t-5">
                                            <button class="btn btn-default border-solid-grey"
                                                    @click="attemptAddShippingFeeModal()">
                                                <span v-if="!POFormObject.shippingFeeAdded">Add</span>
                                                <span v-else="">Edit</span>
                                                Shipping Fee <i class="fa fa-plus"></i>
                                            </button>
                                            <br>
                                            <button class="btn btn-default border-solid-grey m-t-10"
                                                    @click="attemptAddTaxFeeModal()">
                                                <span v-if="!POFormObject.taxFeeAdded">Add</span>
                                                <span v-else="">Edit</span>
                                                Tax Fee <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-lg-6 m-t-5">
                                            <div class="row">
                                                <div class="col-lg-12 border-bottom-grey p-t-10">
                                                    <div class="row">
                                                        <div class="col-lg-6"><p class="fs-16">Shipping Fee</p></div>
                                                        <div class="col-lg-6">
                                                            <span class="fs-16 text-black bold text-left pull-right"
                                                                  v-if="parseInt(POFormObject.shippingFeeAdded)">
                                                              {{POFormObject.currencyFormat}} {{shippingTotal}}
                                                            </span>
                                                            <span class="fs-16 text-black bold text-left pull-right"
                                                                  v-else="">
                                                                -
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 border-bottom-grey p-t-10">
                                                    <div class="row">
                                                        <div class="col-lg-6"><p class="fs-16">Tax Fee</p></div>
                                                        <div class="col-lg-6">
                                                            <span class="fs-16 text-black bold text-left pull-right"
                                                                  v-if="parseInt(POFormObject.taxFeeAdded)">
                                                                {{POFormObject.currencyFormat}} {{taxTotal}}
                                                            </span>
                                                            <span class="fs-16 text-black bold text-left pull-right"
                                                                  v-else="">
                                                                -
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 border-bottom-grey p-t-10">
                                                    <div class="row">
                                                        <div class="col-lg-6"><p class="fs-16">Total</p></div>
                                                        <div class="col-lg-6">
                                                            <span class="fs-18 text-primary bold text-left pull-right"
                                                                  v-if="priceTotal()!=0">
                                                                {{POFormObject.currencyFormat}} {{priceTotalAfterTaxAndShipping}}
                                                            </span>
                                                            <span class="fs-18 text-primary bold text-left pull-right"
                                                                  v-else="">-</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-top: 20px">
                                    <button class="btn btn-primary fs-16 pull-right">Create PO <i
                                            class="fa fa-file"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <add-item-modal></add-item-modal>
        <add-tax-fee-modal></add-tax-fee-modal>
        <add-shipping-fee-modal></add-shipping-fee-modal>

    </div>


</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    import AddItemModal from '../../components/purchaseOrder/AddItemModal.vue'
    import AddTaxFeeModal from '../../components/purchaseOrder/AddTaxFeeModal.vue'
    import AddShippingFeeModal from '../../components/purchaseOrder/AddShippingFeeModal.vue'
    export default{
        components: {
            'add-item-modal': AddItemModal,
            'add-tax-fee-modal': AddTaxFeeModal,
            'add-shipping-fee-modal': AddShippingFeeModal
        },
        data(){
            return {}
        },
        created(){
            let self = this


        },
        computed: {
            ...mapState('purchaseOrder', {
                POFormIsFinishAndValid: 'POFormIsFinishAndValid',
                POItems: 'POItems',
                POFormObject: 'POFormObject'
            }),
            shippingTotal(){

                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                if (parseInt(purchaseOrderVuexState.POFormObject.shippingFeeAdded) == 1) { // prevent  "1" string, required 1 int/boolean

                    let shippingFee = purchaseOrderVuexState.POFormObject.shippingFee

                    return accounting.formatNumber(shippingFee, ',', '.', '')

                } else {
                    return 0
                }

            },
            taxTotal(){

                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                if (parseInt(purchaseOrderVuexState.POFormObject.taxFeeAdded) == 1) { // prevent  "1" string, required 1 int/boolean

                    let tax = purchaseOrderVuexState.POFormObject.taxFee

                    return accounting.formatNumber(tax, ',', '.', '')

                } else {
                    return 0
                }


            },
            priceTotalAfterTaxAndShipping(){

                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                //ITEMS
                let price = self.priceTotal()

                //PRICE
                let shippingFee = 0
                if (purchaseOrderVuexState.POFormObject.shippingFeeAdded) {
                    shippingFee = purchaseOrderVuexState.POFormObject.shippingFee
                }

                //TAX
                let tax = 0
                if (purchaseOrderVuexState.POFormObject.taxFeeAdded) {
                    tax = purchaseOrderVuexState.POFormObject.taxFee

                }

                //Convert everyhing to integer
                shippingFee = parseInt(shippingFee)
                tax = parseInt(tax)
                price = parseInt(price)

                let total = tax + price + shippingFee

                return accounting.formatNumber(total, ',', '.', '')
            },
        },
        mounted(){

        },

        methods: {
            attemptAddItemModal(){
                let self = this
                self.$store.dispatch({
                    type: 'purchaseOrder/attemptAddItemModal'
                })
            },
            formatPrice(amount){
                return accounting.formatNumber(amount, ',', '.', '')
            },
            priceTotal(){
                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                let price = 0

                if (purchaseOrderVuexState.POItems.length > 0) {
                    _.map(purchaseOrderVuexState.POItems, item => {
                        price = price + (item.amount * item.price)
                    })
                }


                return price
            },

            attemptAddTaxFeeModal()
            {
                let self = this
                $('#modal-add-tax-fee').modal('show')
            },
            attemptAddShippingFeeModal()
            {
                let self = this
                $('#modal-add-shipping-fee').modal('show')
            },
            removeItemFromPO(itemId, index){
                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                if(confirm("Are you sure to remove this item from PO")){

                    // remove item from array
                    purchaseOrderVuexState.POItems.splice(index,1)

                    // Update tax value
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

                }


            }
        },
    }
</script>