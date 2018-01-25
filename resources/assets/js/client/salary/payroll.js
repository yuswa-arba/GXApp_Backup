/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/payroll'
import MainPayroll from './MainPayroll.vue'
import {store} from './vuex/payroll/store'

const app =  new Vue({
    el:'#vc-salary-payroll',
    template:`<main-payroll></main-payroll>`,
    components:{MainPayroll},
    router,
    store
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-salary-report-details'),
        itemSelector: ".filter-report-details"
    });
});

