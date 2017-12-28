/**
 * Created by kevinpurwono on 8/12/17.
 */
import Vue from 'vue'
import Vuex from 'vuex'

import list from './modules/list/main'

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules:{
        list
    }
})