/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/employee'
import MainEmployee from './MainEmployee.vue'
import {store} from './vuex/employee/store'

const app =  new Vue({
    el:'#vc-salary-employee',
    template:`<main-employee></main-employee>`,
    components:{MainEmployee},
    router,
    store
})


$(document).ready(function(){
    let employeeBonusCutDT = $('.employeeBonusCutDT');
    employeeBonusCutDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": false,
        "scrollCollapse": false,
        "ordering": false
    })
    $('.dataTables_empty').hide();
});

