/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        items:[],
        paginationMeta: {
            count: '',
            current_page: '',
            links: [],
            per_page: '',
            total: '',
            total_pages: ''
        },
        searchText: '',
        isSearchingItem:false,
        itemToAdd:{
            id:'',
            itemCode:'',
            name:'',
            unitFormat:'',
            statusName:'',
            photo:'',
            isDeleted:''
        },
        addItemToCartAmount:1,
        totalItemInCart:0
    },
    getters,
    mutations,
    actions
}