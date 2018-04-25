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
                    if(res.data.generalInventory.data.length>0){
                        state.generalInventories = res.data.generalInventory.data
                    }
                }
            })
    }
}