<template>

    <div class="col-lg-12">
        <div class="card card-default">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default no-border">
                        <div class="card-block">
                            <div class="row">

                                <div class="col-lg-3">
                                    <p class="text-black text-uppercase fs-11">1. Select Supplier</p>

                                    <div class="input-group">
                                        <input type="text" style="height: 40px;"
                                               class="form-control text-black"
                                               v-model="selectedSupplier.name"
                                               readonly
                                               @click="attemptSelectSupplier()"
                                               placeholder="Search Supplier Name">

                                        <span class="input-group-addon primary"
                                              @click="attemptSelectSupplier()"><i
                                                class="fa fa-mouse-pointer cursor"></i></span>
                                    </div>
                                    <div class="form-group m-t-10">
                                        <label>Contact Person</label>
                                        <input type="text"
                                               class="form-control"
                                               id="extra-contact-person"
                                               v-model="POFormObject.contactPerson">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="number"
                                               class="form-control"
                                               id="extra-contact-number"
                                               v-model="POFormObject.contactNumber">
                                    </div>

                                    <p class="text-black text-uppercase fs-11 p-t-10">2. Select Payment Terms</p>
                                    <div class="form-group m-t-10">
                                        <select class="form-control h-25" v-model="POFormObject.paymentTermId">
                                            <option :value="paymentTerm.id" v-for="paymentTerm in paymentTerms">
                                                {{paymentTerm.name}} ({{paymentTerm.description}})
                                            </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-3">
                                    <p class="text-black text-uppercase fs-11">3. Select Warehouse</p>

                                    <div class="input-group">
                                        <input type="text" style="height: 40px;"
                                               class="form-control text-black"
                                               v-model="selectedWarehouse.name"
                                               readonly
                                               @click="attemptSelectWarehouse()"
                                               placeholder="Search Warehouse ">

                                        <span class="input-group-addon primary"
                                              @click="attemptSelectWarehouse()"><i
                                                class="fa fa-mouse-pointer cursor"></i></span>
                                    </div>
                                    <div class="form-group m-t-10">
                                        <label>Recipient Name</label>
                                        <input type="text"
                                               class="form-control"
                                               id="extra-recipient-person"
                                               v-model="POFormObject.recipientName">
                                    </div>
                                    <div class="form-group">
                                        <label>Recipient Number</label>
                                        <input type="number"
                                               class="form-control"
                                               id="extra-recipient-number"
                                               v-model="POFormObject.recipientNumber">
                                    </div>

                                    <p class="text-black text-uppercase fs-11 p-t-10">4. Select Delivery Terms</p>
                                    <div class="form-group m-t-10">
                                        <select class="form-control h-25" v-model="POFormObject.deliveryTermId">
                                            <option :value="deliveryTerm.id" v-for="deliveryTerm in deliveryTerms">
                                                {{deliveryTerm.name}} ({{deliveryTerm.description}})
                                            </option>
                                        </select>
                                        <input type="text" class="form-control m-t-5" placeholder="Shipping Via" v-model="POFormObject.shippingVia">
                                        <input type="text" class="form-control m-t-5" placeholder="Shipping Mark" v-model="POFormObject.shippingMark">
                                    </div>
                                </div>
                                <div class="col-lg-3 ">
                                    <p class="text-black text-uppercase fs-11">5. Select Requisition</p>
                                    <div class="checkbox check-success ">
                                        <input id="withRequisitionCb"
                                               type="checkbox"
                                               value="1"
                                               @change="withRequisitionCbOnChange()"
                                               v-model="POFormObject.withRequisition">
                                        <label for="withRequisitionCb">With Requisition</label>
                                    </div>

                                    <div class="input-group" v-if="POFormObject.withRequisition">
                                        <input type="text" style="height: 40px;"
                                               class="form-control text-black"
                                               readonly
                                               placeholder="Search Requisition Approval Number"
                                               @click="attemptSelectRequisition()"
                                               v-model="selectedRequisition.approvalNumber"
                                        >
                                        <span class="input-group-addon primary"
                                              @click="attemptSelectRequisition()"><i
                                                class="fa fa-mouse-pointer cursor"></i></span>
                                    </div>

                                    <p class="text-black text-uppercase fs-11 p-t-10">6. Tax Invoice</p>
                                    <div class="checkbox check-success ">
                                        <input id="withTaxInvoice" type="checkbox"
                                               value="1"
                                               v-model="POFormObject.withTaxInvoice">
                                        <label for="withTaxInvoice">With Tax Invoice</label>
                                    </div>

                                    <div v-if="POFormObject.withTaxInvoice">
                                        <div class="form-group">
                                            <label> NPWP No.</label>
                                            <input type="text" class="form-control text-black"
                                                   v-model="POFormObject.npwpNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label> NPWP Attachment</label>
                                            <div class="cursor"
                                                 @click="viewImage('/images/company/npwp/'+POFormObject.npwpPhoto)">
                                                <img :src="'/images/company/npwp/'+POFormObject.npwpPhoto"
                                                     height="70px" alt="">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-3 ">
                                    <p class="text-black text-uppercase fs-11">7. Notes </p>
                                    <div class="form-group m-t-10">
                                        <input type="text" class="form-control"
                                               v-model="POFormObject.notes">
                                    </div>

                                    <p class="text-black text-uppercase fs-11">8. Currency </p>
                                    <div class="form-group m-t-10">
                                        <select name="" id="" class="form-control h-25"
                                                v-model="POFormObject.currencyFormat">
                                            <option :value="currency.format" v-for="currency in currencies">
                                                {{currency.value}} - {{currency.format}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 ">

                                </div>
                                <div class="col-lg-3 ">

                                </div>

                                <div class="col-lg-12 m-t-10">
                                    <button class="btn btn-primary pull-right fs-16" @click="startAddingItems()">
                                        Start Adding Items <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {}
        },
        created(){
            let self = this

            self.$store.dispatch({
                type: 'purchaseOrder/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('purchaseOrder', {
                POFormObject: 'POFormObject',
                selectedSupplier: 'selectedSupplier',
                selectedWarehouse: 'selectedWarehouse',
                selectedRequisition: 'selectedRequisition',
                currencies: 'currencies',
                paymentTerms: 'paymentTerms',
                deliveryTerms: 'deliveryTerms'
            })
        },
        mounted(){

        },

        methods: {
            viewImage(url){
                window.open(url, '_blank')
            },
            attemptSelectRequisition(){
                let self = this
                self.$store.dispatch({
                    type: 'purchaseOrder/showRequisitionListModal'
                })
            },
            attemptSelectSupplier(){
                let self = this
                self.$store.dispatch({
                    type: 'purchaseOrder/showSupplierListModal'
                })
            },
            attemptSelectWarehouse(){
                let self = this
                self.$store.dispatch({
                    type: 'purchaseOrder/showWarehouseListModal'
                })
            },
            withRequisitionCbOnChange(){

                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                let withRequisitionCb = $('#withRequisitionCb')

                if (withRequisitionCb.prop('checked')) {
                } else {
                    //reset value on un checked

                    purchaseOrderVuexState.selectedRequisition = {}
                }
            },
            startAddingItems(){

                let self = this

                this.$store.dispatch({
                    type: 'purchaseOrder/startAddingItems',
                })

            }
        },
    }
</script>