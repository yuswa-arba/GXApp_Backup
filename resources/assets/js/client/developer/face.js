/**
 * Created by kevinpurwono on 28/12/17.
 */

import Vue from 'vue';
import router from './router/face'
import MainFace from './MainFace.vue'

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
    el: '#vc-developer-face',
    template: `<main-face></main-face>`,
    components: {MainFace},
    router
})








$(document).ready(function () {





})