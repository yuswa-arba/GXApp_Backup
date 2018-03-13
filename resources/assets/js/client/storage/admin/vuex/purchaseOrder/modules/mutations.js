/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getNPWPInformation(state, payload){
        get(api_path + 'component/npwpInformation/1')
            .then((res) => {
                state.POFormObject.npwpNo = res.data.data.npwpNo
                state.POFormObject.npwpPhoto = res.data.data.npwpPhoto
            })
    },
    getCurrencies(state, payload){
        get(api_path + 'component/list/currencies')
            .then((res) => {
                state.currencies = res.data.data
            })
    },
    getPaymentTerms(state, payload){
        get(api_path + 'component/list/paymentTerms')
            .then((res) => {
                state.paymentTerms = res.data.data
            })
    },
    getDeliveryTerms(state, payload){
        get(api_path + 'component/list/deliveryTerms')
            .then((res) => {
                state.deliveryTerms = res.data.data
            })
    },
    getUnitOfMeasurements(state, payload){
        get(api_path + 'storage/unit/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.unitOfMeasurements = res.data.units.data
                }
            })
    },
    getPurchaseOrderStatuses(state, payload){
        get(api_path + 'storage/purchaseOrderStatus/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.purchaseOrderStatuses = res.data.purchaseOrderStatuses.data
                }
            })
    },
    getRequisitionList(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/requisition')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.requisitions.data) {

                        state.requisitions = []

                        //insert purchaseOrders
                        let requisitionData = res.data.requisitions.data
                        if (requisitionData) {
                            state.requisitions = state.requisitions.concat(requisitionData)
                        }
                    }
                }
            })
    },
    searchRequisition(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/requisition/search?v=' + payload.searchRequisitionText)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.purchaseOrders.data) {

                        state.purchaseOrders = []

                        //insert purchaseOrders
                        let purchaseOrderData = res.data.purchaseOrders.data
                        if (purchaseOrderData) {
                            state.purchaseOrders = state.purchaseOrders.concat(purchaseOrderData)
                        }
                    }
                }
            })
    },
    getSupplierList(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/supplier')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.suppliers.data) {

                        state.suppliers = []

                        //insert suppliers
                        let suppliersData = res.data.suppliers.data
                        if (suppliersData) {
                            state.suppliers = state.suppliers.concat(suppliersData)
                        }

                    }
                }
            })
    },
    searchSupplier(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/supplier/search?v=' + payload.searchSupplierText)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.suppliers.data) {

                        state.suppliers = []

                        //insert suppliers
                        let suppliersData = res.data.suppliers.data
                        if (suppliersData) {
                            state.suppliers = state.suppliers.concat(suppliersData)
                        }

                    }
                }
            })
    },
    getWarehouseList(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/warehouse')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.warehouses.data) {

                        state.warehouses = []

                        //insert suppliers
                        let warehouseData = res.data.warehouses.data
                        if (warehouseData) {
                            state.warehouses = state.warehouses.concat(warehouseData)
                        }

                    }
                }
            })
    },
    searchWarehouse(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/warehouse/search?v=' + payload.searchWarehouseText)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.warehouses.data) {

                        state.warehouses = []

                        //insert suppliers
                        let warehouseData = res.data.warehouses.data
                        if (warehouseData) {
                            state.warehouses = state.warehouses.concat(warehouseData)
                        }

                    }
                }
            })
    },
    searchItems(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/item/search?v=' + payload.searchItemText)
            .then((res) => {

                //reset item
                state.items = []

                if (!res.data.isFailed) {
                    if (res.data.items.data) {

                        //insert items
                        let itemsData = res.data.items.data
                        if (itemsData) {
                            state.items = state.items.concat(itemsData)
                        }
                    }
                }
            })
    },

    createPO(state, payload){
        post(api_path + 'storage/admin/purchaseOrder/create', {
            POForm: state.POFormObject,
            POItems: state.POItems
        })
            .then((res) => {

                if (!res.data.isFailed) {

                    series([
                        function (cb) {
                            setTimeout(() => { //success notification

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();


                            }, 1000)
                            cb(null, '')
                        },
                        function (cb) { // redirecting notification
                            setTimeout(() => {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'Redirecting to PO list..',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'success'
                                }).show();

                                state.isCreatingPurchaseOrder = false
                            }, 1500)
                            cb(null, '')
                        },
                        function (cb) { //redirecting
                            setTimeout(() => {
                                //redirected to purchase order list
                                window.location.href = '/storage/admin/purchaseOrder'
                            }, 3000)
                            cb(null, '')
                        }
                    ])

                } else {

                    state.isCreatingPurchaseOrder = false

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

                state.isCreatingPurchaseOrder = false

                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    },
    getPurchaseOrderList(state, payload){

        let sortStatus = ''
        if (payload.sortStatus) {
            sortStatus = payload.sortStatus
        }

        get(api_path + 'storage/admin/purchaseOrder/list?sortStatus=' + sortStatus)
            .then((res) => {

                state.isSearchingPO = true

                if (!res.data.isFailed) {
                    if (res.data.purchaseOrders.data) {

                        state.purchaseOrders = []

                        //insert purchaseOrders
                        let purchaseOrderData = res.data.purchaseOrders.data
                        if (purchaseOrderData) {
                            state.purchaseOrders = state.purchaseOrders.concat(purchaseOrderData)
                        }

                        //insert pagination
                        state.paginationMeta = res.data.purchaseOrders.meta.pagination
                    }

                    state.isSearchingPO = false

                } else {
                    state.isSearchingPO = false
                }
            })
            .catch((err) => {
                state.isSearchingPO = true
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    },
    updateStatus(state, payload){

        if (payload.purchaseOrderId != '' && payload.statusId != '') {

            post(api_path + 'storage/admin/purchaseOrder/update/status', {
                purchaseOrderId: payload.purchaseOrderId,
                statusId: payload.statusId
            })
                .then((res) => {

                    if (!res.data.isFailed) {

                         $('.page-container').pgNotification({
                              style: 'flip',
                              message: res.data.message,
                              position: 'top-right',
                              timeout: 3500,
                              type: 'info'
                          }).show();

                        //update status in array
                        state.purchaseOrders[payload.index].statusId = payload.statusId
                        state.purchaseOrders[payload.index].status = payload.status

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


        }

    }

}