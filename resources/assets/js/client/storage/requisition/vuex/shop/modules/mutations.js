/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{

    getTotalItemInCart(state, payload){

        get(api_path + 'storage/requisition/shop/cart/totalItemInCart')
            .then((res) => {
                if (!res.data.isFailed) {
                    if(res.data.totalItemInCart){
                        state.totalItemInCart = res.data.totalItemInCart
                    }
                }
            })

    },
    searchItems(state, payload){

        let search = ''
        if (payload.searchText) {
            search = payload.searchText
        }

        get(api_path + 'storage/requisition/shop/item/search?v=' + search)
            .then((res) => {

                    state.isSearchingItem = true

                    if (!res.data.isFailed) {
                        if (res.data.items.data) {

                            state.items = []

                            //insert items
                            let itemsData = res.data.items.data
                            if (itemsData) {
                                state.items = state.items.concat(itemsData)
                            }

                            //insert pagination
                            state.paginationMeta = res.data.items.meta.pagination
                        }

                        state.isSearchingItem = false

                    } else {
                        state.isSearchingItem = false
                    }
                }
            )
    },
    getItemList(state, payload){

        let param = '';

        if (payload.sortStatusId) { // sort by status
            if (param != '') {
                param += '&'
            }
            param += 'status=' + payload.sortStatusId
        }

        if (payload.sortCategoryCode) { // sort by category
            if (param != '') {
                param += '&'
            }
            param += 'categoryCode=' + payload.sortCategoryCode
        }

        if (payload.sortTypeCode) { // sort by type
            if (param != '') {
                param += '&'
            }
            param += 'typeCode=' + payload.sortTypeCode
        }


        //get next page
        get(api_path + 'storage/requisition/shop/item/list?' + param)
            .then((res) => {

                state.isSearchingItem = true

                if (!res.data.isFailed) {

                    if (res.data.items.data) {

                        state.items = []

                        //insert items
                        let itemsData = res.data.items.data
                        if (itemsData) {
                            setTimeout(() => {
                                state.items = state.items.concat(itemsData)
                            }, 500)
                        }

                        //insert pagination
                        state.paginationMeta = res.data.items.meta.pagination
                    }

                    state.isSearchingItem = false
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();

                    state.isSearchingItem = false

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

                state.isSearchingItem = false
            })

    },
    getItemDetail(state, payload){
        if (payload.id) {

            get(api_path + 'storage/requisition/shop/item/detail?id=' + payload.id)
                .then((res) => {

                    if (!res.data.isFailed) {

                        if (res.data.item.data) {

                            let itemData = res.data.item.data

                            //insert data to state

                            state.itemToAdd.id = itemData.id
                            state.itemToAdd.itemCode = itemData.itemCode
                            state.itemToAdd.name = itemData.name
                            state.itemToAdd.unitFormat = itemData.unitFormat
                            state.itemToAdd.statusName = itemData.statusName
                            state.itemToAdd.photo = itemData.photo
                            state.itemToAdd.isDeleted = itemData.isDeleted
                        }

                    } else {

                        //error response
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();

                        //close modal
                        $('#modal-attempt-add-item-to-cart').modal('toggle')
                    }


                })
                .catch((err) => {

                    //error response
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();

                    //close modal
                    $('#modal-attempt-add-item-to-cart').modal('toggle')

                })


        } else {
            //error notification
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Undefined item ID',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }
    },
    addToCart(state, payload){

        console.log(JSON.stringify(state.itemToAdd))

        if (state.itemToAdd.id != '' && state.addItemToCartAmount > 0) {

            post(api_path + 'storage/requisition/shop/cart/add', {
                itemId: state.itemToAdd.id,
                amount: state.addItemToCartAmount
            })
                .then((res) => {
                    if (!res.data.isFailed) {

                        $('.page-container').pgNotification({ //success response
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'info'
                        }).show();

                        //increment item inside cart
                        state.totalItemInCart++

                        //close modal
                        $('#modal-attempt-add-item-to-cart').modal('toggle')

                        //reset itemToAdd state
                        state.itemToAdd = {
                            id: '',
                            itemCode: '',
                            name: '',
                            unitFormat: '',
                            statusName: '',
                            photo: '',
                            isDeleted: ''
                        }

                        //reset addItemToCartAmount state
                        state.addItemToCartAmount = 1

                    } else { //error response
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }
                })
                .catch((err) => { //error response
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                })

        } else {

            //close modal
            $('#modal-attempt-add-item-to-cart').modal('toggle')

            //reset itemToAdd state
            state.itemToAdd = {
                id: '',
                itemCode: '',
                name: '',
                unitFormat: '',
                statusName: '',
                photo: '',
                isDeleted: ''
            }

            //reset addItemToCartAmount state
            state.addItemToCartAmount = 1

            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Undefined item ID or Invalid amount',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();

        }
    }


}