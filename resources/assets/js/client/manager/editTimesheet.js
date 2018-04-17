/**
 * Created by kevinpurwono on 15/11/17.
 */

import Vue from 'vue'
import MainEditTimesheet from './MainEditTimesheet.vue'
import router from './router/editTimesheet'
import {store} from './vuex/editTimesheet/store'

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
    el:'#vc-manager-edit-timesheet',
    template:`<main-edit-timesheet></main-edit-timesheet>`,
    components:{MainEditTimesheet},
    router,
    store
})



$(document).ready(function () {

})