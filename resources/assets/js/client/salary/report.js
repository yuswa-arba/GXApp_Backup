/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/report'
import MainReport from './MainReport.vue'
import {store} from './vuex/report/store'

const app =  new Vue({
    el:'#vc-salary-report',
    template:`<main-report></main-report>`,
    components:{MainReport},
    router,
    store
})


$(document).ready(function(){


    $('.filter-container').sieve({
        searchInput: $('#search-log-details'),
        itemSelector: ".filter-log-details"
    });

});

