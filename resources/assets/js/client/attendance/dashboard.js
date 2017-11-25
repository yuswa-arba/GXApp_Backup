/**
 * Created by kevinpurwono on 23/11/17.
 */
/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue';
import router from './router/dashboard'
import MainDashboard from './MainDashboard.vue'

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
    el: '#vc-attendance-dashboard',
    template:`<dashboard></dashboard>`,
    components:{MainDashboard},
    router
})


