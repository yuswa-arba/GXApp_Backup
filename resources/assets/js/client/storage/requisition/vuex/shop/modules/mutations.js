/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{

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
                            setTimeout(()=>{
                                state.items = state.items.concat(itemsData)
                            },500)
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

    }


}