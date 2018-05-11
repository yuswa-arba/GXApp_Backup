/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/queue'
import MainQueue from './MainQueue.vue'
import {store} from './vuex/queue/store'

const app =  new Vue({
    el:'#vc-salary-queue',
    template:`<main-queue></main-queue>`,
    components:{MainQueue},
    router,
    store
})


$(document).ready(function(){

});

