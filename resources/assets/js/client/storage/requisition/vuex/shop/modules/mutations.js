/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{

    searchItems(state, payload){

        get(api_path + 'storage/requisition/shop/item/search?v=' + payload.searchText)
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


}