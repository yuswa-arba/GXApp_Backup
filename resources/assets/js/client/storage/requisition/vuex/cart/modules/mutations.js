/**
 * Created by kevinpurwono on 8/12/17.
 */

import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getDeliveryWarehouses(state, payload){
        get(api_path + 'storage/warehouse/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.deliveryWarehouses = res.data.warehouses.data
                }
            })
    },
    getDivisions(state, payload){
        get(api_path + 'component/list/divisions')
            .then((res) => {
                state.divisions = res.data.data
            })

    },
    getItemInsideCarts(state, payload){

        get(api_path + 'storage/requisition/shop/cart/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.itemInsideCart.data) {
                        state.itemInsideCart = res.data.itemInsideCart.data
                    }
                }
            })
    },
    getItemBeingRequestedDetails(state, payload){
        post(api_path + 'storage/requisition/itemBeingRequested/list', {
            itemCartIds: state.selectedItemsIdToRequest
        })
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.itemsBeingRequested.data) {
                        state.itemsBeingRequested = res.data.itemsBeingRequested.data
                    }
                }
            })
    },
    updateItemAmountInCart(state, payload){
        if (payload.itemCartId) {
            post(api_path + 'storage/requisition/shop/cart/updateItemAmountInCart', {
                    itemCartId: payload.itemCartId,
                    amount: payload.amount
                }
            )
                .then((res) => {
                })
                .catch((err) => {
                })
        }

    },
    updateItemNotesInCart(state, payload){
        if (payload.itemCartId) {
            post(api_path + 'storage/requisition/shop/cart/updateItemNotesInCart', {
                    itemCartId: payload.itemCartId,
                    notes: payload.notes
                }
            )
                .then((res) => {
                })
                .catch((err) => {
                })
        }
    },
    removeItem(state, payload){
        post(api_path + 'storage/requisition/shop/cart/remove', {
            itemCartId: payload.itemCartId
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

                    //remove from array
                    state.itemInsideCart.splice(payload.index, 1)

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
    removeAllItems(state, payload){
        post(api_path + 'storage/requisition/shop/cart/removeAll')
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    //empty array
                    state.itemInsideCart = []

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
    createRequisition(state, payload){
        post(api_path + 'storage/requisition/create', state.requisitionForm)
            .then((res) => {
                if (!res.data.isFailed) {

                    state.isSubmittingRequisition = false

                     $('.page-container').pgNotification({
                          style: 'flip',
                          message: res.data.message,
                          position: 'top-right',
                          timeout: 3500,
                          type: 'info'
                      }).show();

                     setTimeout(()=>{

                         //move to track & history page8
                         window.location.href='/storage/requisition/history'

                     },2000)

                } else {

                    state.isSubmittingRequisition = false

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

                state.isSubmittingRequisition = false

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