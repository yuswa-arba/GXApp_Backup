<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-12 m-b-10">
            <div class="card card-default card-bordered border-solid-grey">
                <div class="card-block no-padding">
                    <div class="col-lg-12 border-bottom-grey" style="background:#fafafa;">
                        <div class="row">
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Purchase Order No.</p>
                                <p class="text-black fs-18 m-b-10">{{purchaseOrder.purchaseOrderNumber}}</p>

                                <p class="text-uppercase m-b-0">Approval No.</p>
                                <p class="text-black fs-16 m-b-10" v-if="purchaseOrder.withRequisition">
                                    {{purchaseOrder.approvalNumber}}</p>
                                <p v-else="">-</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Date</p>
                                <p class="text-black fs-16 m-b-10">{{purchaseOrder.date}}</p>

                                <p class="text-uppercase m-t-10 m-b-0">Status</p>
                                <p class="text-black fs-14 m-b-10">{{purchaseOrder.status}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Supplier Details</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.supplierName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-user"></i>
                                    {{purchaseOrder.contactPerson}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-mobile"></i>
                                    {{purchaseOrder.contactNumber}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Ship To</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.warehouseName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-user"></i>
                                    {{purchaseOrder.recipientName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-mobile"></i>
                                    {{purchaseOrder.recipientPerson}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Notes</p>
                                <p class="text-black fs-14 m-b-10">{{purchaseOrder.notes}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 border-bottom-grey" style="background:#fafafa;">
                        <div class="row">
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Requisitioner</p>
                                <p class="text-black fs-18 m-b-10">{{purchaseOrder.requisitioner}}</p>

                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Shipping Via</p>
                                <p class="text-black fs-16 m-b-10">{{purchaseOrder.shippingVia}}</p>

                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Term of Payments</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.paymentTerm}}</p>

                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Term of Delivery</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.deliveryTerm}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Shipping Mark</p>
                                <p class="text-black fs-14 m-b-10">{{purchaseOrder.shippingMark}}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="purchaseOrder.purchaseOrderItems">
                        <div class="col-lg-12 p-t-10 border-bottom-grey"
                             v-for="(item,index) in purchaseOrder.purchaseOrderItems.data">
                            <div class="row">
                                <div class="col-lg-3 m-t-5">
                                    <p class="m-b-0 fs-16"> Amount : <span
                                            class="text-black">{{item.amountPurchased}}</span></p>
                                    <p class="m-b-0 fs-16" v-if="item.hasCustomUnit"> Unit :
                                        {{item.customUnit}}</p>
                                    <p class="m-b-0 fs-16" v-else="">Unit : {{item.unitFormatPurchased}}</p>
                                </div>
                                <div class="col-lg-2 m-t-5">
                                    <p class="text-black fs-16 m-b-0 bold">{{item.itemName}}</p>
                                    <p class="m-b-10">{{item.itemCode}}</p>
                                </div>
                                <div class="col-lg-2 m-t-5">
                                    <p class="m-b-0">inserted item</p>
                                    <p class="text-black m-b-10 fs-16">{{item.inventoryHistory}}</p>
                                </div>
                                <div class="col-lg-2 m-t-5">
                                    <button class="btn btn-outline-primary"
                                            @click="attemptInsertItemToInventory(item.itemId,index)"
                                    >
                                        <i class="fa fa-plus"></i> Insert to Inventory
                                    </button>
                                </div>
                                <div class="col-lg-2 m-t-5">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="p-t-50"></div>

                    <div class="p-t-50"></div>
                </div>

            </div>

        </div>
        <insert-item-to-inventory-modal></insert-item-to-inventory-modal>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import {mapGetters, mapState} from 'vuex'
    import InsertItemToInventoryModal from '../../components/inventory/AttemptInsertToInventoryModal.vue'
    export default{
        components: {
            'insert-item-to-inventory-modal': InsertItemToInventoryModal
        },
        data(){
            return {

            }
        },
        created(){

            let self = this

            this.$store.dispatch('entry/getDataOnCreate')

            //get PO detail
            this.getPODetail()

        },
        computed:{
            ...mapState('entry',{
                purchaseOrder:'currentPurchaseOrder'
            })
        },
        methods: {
            formatPrice(amount){
                return accounting.formatNumber(amount, ',', '.', '')
            },
            getPODetail(){
                let self = this
                let entryVuexState = this.$store.state.entry
                get(api_path + 'storage/inventory/purchaseOrder/detail?id=' + this.$route.params.id)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            if (res.data.purchaseOrder.data) {
                                entryVuexState.currentPurchaseOrder = res.data.purchaseOrder.data
                            }

                        } else {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        }
                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })
            },
            attemptInsertItemToInventory(itemId, index){
                let self = this
                let entryVuexState = this.$store.state.entry

                //reset default values
                entryVuexState.selectedItemToInsert = {
                    itemId: '',
                    itemName: '',
                    itemCode: '',
                    requiresSerialNumber: 0,
                    quantity: 1
                }

                entryVuexState.selectedPurchaseOrderId = ''
                entryVuexState.selectedBranchOfficeId = ''

                //re fetch data
                self.getPODetail()

                //give delay for 0.3 second to refetch the data first
                setTimeout(() => {
                    this.$store.dispatch({
                        type: 'entry/attemptInsertItemToInventory',
                        itemId: itemId,
                        itemIndex: index
                    })
                }, 300)
            }
        }
    }
</script>