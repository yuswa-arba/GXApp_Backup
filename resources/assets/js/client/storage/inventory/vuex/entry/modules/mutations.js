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
    }
}