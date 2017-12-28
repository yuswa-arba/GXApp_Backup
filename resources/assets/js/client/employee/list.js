/**
 * Created by kevinpurwono on 15/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue'
import MainList from './MainList.vue'
import router from './router'
import {store} from './vuex/store'

// Create a global Event Bus
let EventBus = new Vue()

// Add to Vue properties by exposing a getter for $bus
Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return EventBus;
        }
    }
})

const app = new Vue({
    el:'#vc-employee-list',
    template:`<main-list></main-list>`,
    components:{MainList},
    router,
    store
})