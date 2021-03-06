/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/slot'
import MainSlot from './MainSlot.vue'
import {store} from './vuex/slot/store'

const app =  new Vue({
    el:'#vc-attendance-slot',
    template:`<main-slot></main-slot>`,
    components:{MainSlot},
    router,
    store
})


$(document).ready(function(){

    let slotDT = $('.slotDT');

    slotDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": true,
        "scrollCollapse": false,
        "ordering": false
    })

});

