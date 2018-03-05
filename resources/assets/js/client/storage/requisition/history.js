/**
 * Created by kevinpurwono on 6/12/17.
 */
import Vue from 'vue'
import router from './router/history'
import MainHistory from './MainHistory.vue'
import {store} from './vuex/history/store'

const app =  new Vue({
    el:'#vc-storage-requisition-history',
    template:`<main-history></main-history>`,
    components:{MainHistory},
    router,
    store
})


$(document).ready(function(){


});

