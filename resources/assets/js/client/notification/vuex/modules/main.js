/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        notificationList:[],
        unreadExists:false
    },
    getters,
    mutations,
    actions
}