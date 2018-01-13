/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/schedule'
import MainSchedule from './MainSchedule.vue'

const app =  new Vue({
    el:'#vc-attendance-schedule',
    template:`<main-schedule></main-schedule>`,
    components:{MainSchedule},
    router
})


$(document).ready(function(){

    let scheduleDT = $('.scheduleDT');

    scheduleDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": true,
        "scrollCollapse": false,
        "ordering": false
    })
    $('.dataTables_empty').hide();

});

