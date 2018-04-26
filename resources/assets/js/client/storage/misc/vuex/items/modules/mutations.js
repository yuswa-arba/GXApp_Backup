/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{

    getItemCategories(state, payload){
        //get categories list
        get(api_path + 'storage/itemCategory/list')
            .then((res) => {
                state.categories = res.data.categories.data
            })
    },
    getItemTypes(state, payload){
        //get item types list
        get(api_path + 'storage/itemType/list')
            .then((res) => {
                state.types = res.data.types.data
            })
    },
    getItemUnits(state, payload){
        //get units list
        get(api_path + 'storage/unit/list')
            .then((res) => {
                state.units = res.data.units.data
            })
    },
    getItemStatuses(state, payload){
        //get status list
        get(api_path + 'storage/status/list')
            .then((res) => {
                state.statuses = res.data.status.data
            })
    },
    deleteItem(state, payload){
        post(api_path + 'storage/delete/item', {id: payload.id})
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    state.items[payload.index].isDeleted = 1

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
    undoDeleteItem(state, payload){
        post(api_path + 'storage/undoDelete/item', {id: payload.id})
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    state.items[payload.index].isDeleted = 0

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
    saveEditItemPrice(state, payload){
        post(api_path + 'storage/item/editPrice', {
            id: state.selectedItem.id,
            finePrice: state.selectedItem.finePrice,
            sellingPrice: state.selectedItem.sellingPrice,
            purchasedPrice: state.selectedItem.purchasedPrice
        }).then((res) => {
            if (!res.data.isFailed) {

                $('.page-container').pgNotification({
                    style: 'flip',
                    message: res.data.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'info'
                }).show();

                //edit items
                state.items[state.selectedItem.itemIndex].latestSellingPrice = state.selectedItem.sellingPrice
                state.items[state.selectedItem.itemIndex].latestPurchasedPrice = state.selectedItem.purchasedPrice
                state.items[state.selectedItem.itemIndex].finePrice = state.selectedItem.finePrice

                //close modal
                $('#modal-edit-item-price').modal('toggle')

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