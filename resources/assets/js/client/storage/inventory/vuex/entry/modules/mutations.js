/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getPurchaseOrderStatuses(state, payload){
        get(api_path + 'storage/purchaseOrderStatus/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.purchaseOrderStatuses = res.data.purchaseOrderStatuses.data
                }
            })
    },
    getBranchOffices(state, payload){
        get(api_path + 'component/list/branchOffices')
            .then((res) => {
                state.branchOffices = res.data.data
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
    searchPurchaseOrder(state, payload){

        let search = ''
        if (payload.searchText) {
            search = payload.searchText
        }

        get(api_path + 'storage/admin/purchaseOrder/search?v=' + search)
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
    insertToInventory(state, payload){

        post(api_path + 'storage/inventory/entry', {
            storagePurchaseOrderId: payload.purchaseOrderId,
            branchOfficeId: payload.branchOfficeId,
            items: payload.itemsToInsert
        }).then((res) => {

            if (!res.data.isFailed) {

                 $('.page-container').pgNotification({
                      style: 'flip',
                      message: res.data.message,
                      position: 'top-right',
                      timeout: 3500,
                      type: 'info'
                  }).show();

                 //close modal
                $('#modal-attempt-insert-to-inventory').modal('toggle')

                //re fetch PO detail
                get(api_path + 'storage/inventory/purchaseOrder/detail?id=' + payload.purchaseOrderId)
                    .then((res) => {
                        if (!res.data.isFailed) {
                            if (res.data.purchaseOrder.data) {
                                state.currentPurchaseOrder = res.data.purchaseOrder.data
                            }
                        }
                    })
                    .catch((err) => {})

            } else {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: res.data.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            }
        }).catch((err) => {
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