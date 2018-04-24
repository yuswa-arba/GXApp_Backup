/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        isSearchingPO:false,
        purchaseOrders:[],
        purchaseOrderStatuses:[],
        paginationMeta:{
            total: '',
            count: '',
            per_page: '',
            current_page: '',
            total_pages: '',
            links: []
        },
    },
    getters,
    mutations,
    actions
}