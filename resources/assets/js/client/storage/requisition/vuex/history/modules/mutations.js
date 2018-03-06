/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{

    getRequisitionHistory(state, payload){
        get(api_path + 'storage/requisition/history')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.requisitionsHistory = res.data.requisitions.data
                    state.requisitionPagination = res.data.requisitions.meta.pagination
                }
            })
    },
    searchRequisition(state, payload){

        let search = ''
        if (payload.searchText) {
            search = payload.searchText
        }

        get(api_path + 'storage/requisition/history/search?v=' + search)
            .then((res) => {

                    state.isSearchingRequisition = true

                    if (!res.data.isFailed) {
                        if (res.data.requisitions.data) {

                            state.requisitions = []

                            //insert requisitions
                            let requisitionData = res.data.requisitions.data
                            if (requisitionData) {
                                state.requisitions = state.requisitions.concat(requisitionData)
                            }

                            //insert pagination
                            state.paginationMeta = res.data.requisitions.meta.pagination
                        }

                        state.isSearchingRequisition = false

                    } else {
                        state.isSearchingRequisition = false
                    }
                }
            )
    }

}