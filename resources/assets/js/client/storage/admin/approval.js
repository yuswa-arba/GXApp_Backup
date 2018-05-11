/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/approval'
import MainApproval from './MainApproval.vue'
import {store} from './vuex/approval/store'

const app =  new Vue({
    el:'#vc-storage-admin-approval',
    template:`<main-approval></main-approval>`,
    components:{MainApproval},
    router,
    store
})


$(document).ready(function(){

});

