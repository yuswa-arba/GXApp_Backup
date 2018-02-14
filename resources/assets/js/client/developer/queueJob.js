/**
 * Created by kevinpurwono on 28/12/17.
 */


require('../../bootstrap')

import Vue from 'vue';
import router from './router/queueJob'
import MainQueueJob from './MainQueueJob.vue'

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
    el: '#vc-queue-job',
    template: `<main-queue-job></main-queue-job>`,
    components: {MainQueueJob},
    router
})









$(document).ready(function () {





})