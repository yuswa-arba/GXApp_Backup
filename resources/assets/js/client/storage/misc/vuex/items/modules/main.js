/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        selectedItem :{
            id:'',
            itemIndex:'',
            itemName:'',
            itemCode:'',
            sellingPrice:'',
            purchasedPrice:'',
            finePrice:''
        },
        items:[],
        categories:[],
        types:[],
        units:[],
        statuses:[],
        paginationMeta : {
            count: '',
            current_page: '',
            links: [],
            per_page: '',
            total: '',
            total_pages: ''
        },

    },
    getters,
    mutations,
    actions
}