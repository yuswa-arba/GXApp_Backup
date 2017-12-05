/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue';
import router from './router/index'
import MainDoorAccess from './Main.vue'

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
    el: '#vc-door-access',
    template: `<main-door-access></main-door-access>`,
    components: {MainDoorAccess},
    router
})

