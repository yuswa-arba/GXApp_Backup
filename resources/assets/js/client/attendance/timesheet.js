/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/timesheet'
import MainSlot from './MainTimesheet.vue'
import {store} from './vuex/timesheet/store'

const app =  new Vue({
    el:'#vc-attendance-timesheet',
    template:`<main-slot></main-slot>`,
    components:{MainSlot},
    router,
    store
})


$(document).ready(function(){

    let timesheetDT = $('.timesheetDT');

    timesheetDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": true,
        "scrollCollapse": false,
        "ordering": false
    })


    $('#sortTimesheetDate').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight:true
    });

    $('#sortTimesheetDate').val(moment().format('DD/MM/YYYY'))

    $('.dataTables_empty').hide()

});

