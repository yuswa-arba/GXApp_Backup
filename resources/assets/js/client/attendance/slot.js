/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/slot'
import MainSlot from './MainSlot.vue'

// TODO : consider using VUEX instead
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

const app =  new Vue({

    el:'#vc-attendance-slot',
    template:`<main-slot></main-slot>`,
    components:{MainSlot},
    router
})


$(document).ready(function(){

    let slotDT = $('.slotDT');

    slotDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": false,
        "scrollCollapse": false
    })



});

