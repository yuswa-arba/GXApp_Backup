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
    }

}