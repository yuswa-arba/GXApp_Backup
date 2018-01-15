/**
 * Created by kevinpurwono on 15/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue'
import MainResignation from './MainResignation.vue'
import router from './router/resignation'

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
    el:'#vc-employee-resignation',
    template:`<main-resignation></main-resignation>`,
    components:{MainResignation},
    router
})



$(document).ready(function () {

})