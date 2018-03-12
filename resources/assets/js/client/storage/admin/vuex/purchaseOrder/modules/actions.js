/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}, payload){
        commit('getNPWPInformation')
        commit('getCurrencies')
        commit('getPaymentTerms')
        commit('getDeliveryTerms')
        commit('getUnitOfMeasurements')
        commit('getPurchaseOrderStatuses')
    },
    showRequisitionListModal({commit, state}, payload){

        commit('getRequisitionList')
        $('#modal-select-requisition').modal('show')

    },
    showSupplierListModal({commit, state}, payload){

        commit('getSupplierList')
        $('#modal-select-supplier').modal('show')

    },
    showWarehouseListModal({commit,state},payload){
        commit('getWarehouseList')
        $('#modal-select-warehouse').modal('show')
    },
    startAddingItems({commit, state}, payload){

        //validate and check pre form object

        series([
                function (cb) {
                    // check if with supplier
                    if (state.selectedSupplier.id != null) {

                        // Insert to POFormObject
                        state.POFormObject.supplierId = state.selectedSupplier.id

                        // Callback success
                        cb(null, '')

                    } else {
                        // Callback error
                        cb('Supplier not found', '')
                    }
                },
                function (cb) {
                    // check payment terms
                    if (state.POFormObject.paymentTermId != null && state.POFormObject.paymentTermId != '') {

                        // Callback success
                        cb(null, '')

                    } else {
                        // Callback error
                        cb('Payment term cannot be empty', '')
                    }
                },
                function (cb) {
                    // check if with warehouse
                    if (state.selectedWarehouse.id != null) {

                        // Insert to POFormObject
                        state.POFormObject.warehouseId = state.selectedWarehouse.id

                        if(state.POFormObject.recipientName!=''){
                            // Callback success
                            cb(null, '')
                        } else {
                            // Callback error
                            cb('Recipient cannot be empty', '')
                        }

                    } else {
                        // Callback error
                        cb('Warehouse not found', '')
                    }
                },
                function (cb) {
                    // check payment terms
                    if (state.POFormObject.deliveryTermId != null && state.POFormObject.deliveryTermId != '') {

                        // Callback success
                        cb(null, '')

                    } else {
                        // Callback error
                        cb('Delivery term cannot be empty', '')
                    }
                },
                function (cb) {

                    // check if with requisition
                    if (state.POFormObject.withRequisition) {
                        if (state.selectedRequisition.id != null) {

                            // Insert to POFormObject
                            state.POFormObject.requisitionId = state.selectedRequisition.id
                            state.POFormObject.approvalNumber = state.selectedRequisition.approvalNumber

                            //Get items from this requisition
                            commit({
                                type:'getItemInRequisition',
                                requisitionId:state.selectedRequisition.id
                            })

                            // Callback success
                            cb(null, '')

                        } else {
                            // Callback error
                            cb('Requisition not found', '')
                        }
                    } else {

                        // Callback success
                        cb(null, '')
                    }
                }
            ],
            function (err, result) { // Callback

                if (err == null) { //Success

                    state.POFormIsFinishAndValid = true

                } else {

                    /* Show error response */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })
    },
    attemptAddItemModal({commit, state}, payload){
        //show modal
        $('#modal-add-item').modal('show')
    },
    insertItemToPO({commit, state}, payload){

        //validate and check object before insert into PO Items
        series([
            function (cb) {
                if (state.itemToBeInserted.itemDetail.id != null) {

                    //Callback Success
                    cb(null, '')

                } else {
                    //Callback Error
                    cb('Item to be inserted ID undefined', '')
                }
            },
            function (cb) {

                if (state.itemToBeInserted.hasCustomUnit) {

                    if (state.itemToBeInserted.customUnit != '') {
                        cb(null, '')// Callback success
                    } else {
                        cb('Custom Unit cannot be empty', '') // Callback error
                    }

                } else {
                    if (state.itemToBeInserted.unitId != '') {
                        cb(null, '') // Callback success
                    } else {
                        cb('Unit type cannot be empty', '') // Callback error
                    }
                }

            },
            function (cb) {

                if (state.itemToBeInserted.amount != ''
                    && state.itemToBeInserted.price != ''
                    && state.itemToBeInserted.currencyFormat != ''
                ) {
                    cb(null, '')// Callback Success
                } else {
                    cb('Form is not complete', '') // Callback error
                }

            }


        ], function (err, result) {

            if (err == null) { //Success

                series([
                    function (cb) {

                        // Insert to PO item array
                        state.POItems.push(state.itemToBeInserted)
                        cb(null, '')
                    },
                    function(cb){

                        //update tax value
                        if(parseInt(state.POFormObject.taxFeeAdded)==1){
                            let price = 0
                            if (state.POItems.length > 0){
                                _.map(state.POItems, item => {
                                    price = price + (item.amount * item.price)
                                })
                            }

                            // insert tax fee
                            state.POFormObject.taxFee = (price * 10 / 100)
                        } else {
                            state.POFormObject.taxFee = 0
                        }

                        cb(null,'')
                    },
                    function (cb) {

                        // Close Modal  & Reset forms
                        state.items = []//resset items lsit
                        state.itemToBeInserted = { //reset item to be inserted data
                            withRequisitionItem:0,
                            requisitionItemId:'',
                            itemDetail: {},
                            amount:'',
                            hasCustomUnit:0,
                            customUnit:'',
                            unitId:'',
                            unitFormat:'',
                            price:'',
                            currencyFormat:'IDR'
                        }

                        $('#modal-add-item').modal("toggle"); // close modal
                        cb(null, '')
                    }
                ])

            } else {

                /* Show error response */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            }
        })

    },

}