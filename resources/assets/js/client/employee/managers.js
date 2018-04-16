/**
 * Created by kevinpurwono on 15/11/17.
 */

import Vue from 'vue'
import MainManagers from './MainManagers.vue'
import router from './router/managers'
import {store} from './vuex/managers/store'

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
    el:'#vc-employee-managers',
    template:`<main-managers></main-managers>`,
    components:{MainManagers},
    router,
    store
})



$(document).ready(function () {

})