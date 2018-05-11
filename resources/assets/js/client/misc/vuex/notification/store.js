/**
 * Created by kevinpurwono on 8/12/17.
 */
import Vue from 'vue'
import Vuex from 'vuex'

import notification from './modules/main'

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules:{
        notification
    }
})