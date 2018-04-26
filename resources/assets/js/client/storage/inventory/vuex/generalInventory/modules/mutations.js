/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getGeneralInventoryList(state, payload){
        get(api_path + 'storage/inventory/general/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.generalInventory.data) {

                        state.generalInventories = []

                        //insert generalInventory
                        let generalInventoryData = res.data.generalInventory.data
                        if (generalInventoryData) {
                            state.generalInventories = state.generalInventories.concat(generalInventoryData)
                        }

                        //insert pagination
                        state.paginationMeta = res.data.generalInventory.meta.pagination
                    }
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
    searchItems(state, payload){
        get(api_path + 'storage/inventory/general/search?v=' + payload.text)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.generalInventory.data) {

                        state.generalInventories = []

                        //insert generalInventory
                        let generalInventoryData = res.data.generalInventory.data
                        if (generalInventoryData) {
                            state.generalInventories = state.generalInventories.concat(generalInventoryData)
                        }

                        //insert pagination
                        state.paginationMeta = res.data.generalInventory.meta.pagination
                    }
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