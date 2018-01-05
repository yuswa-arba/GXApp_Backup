/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/dashboard'
import MainSlot from './MainDashboard.vue'
import {store} from './vuex/dashboard/store'

const app =  new Vue({
    el:'#vc-attendance-dashboard',
    template:`<main-slot></main-slot>`,
    components:{MainSlot},
    router,
    store
})


$(document).ready(function(){

    let liveClockFeedDT = $('#liveClockFeedDT');

    liveClockFeedDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": true,
        "scrollCollapse": false,
        "ordering": false
    })



    $('.dataTables_empty').hide()

});

