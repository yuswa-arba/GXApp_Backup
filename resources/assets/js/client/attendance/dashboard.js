/**
 * Created by kevinpurwono on 6/12/17.
 */

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

});

