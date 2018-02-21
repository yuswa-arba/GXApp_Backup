/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/notification'
import MainNotification from './MainNotification.vue'
import {store} from './vuex/notification/store'

const app =  new Vue({
    el:'#vc-setting-notification',
    template:`<main-notification></main-notification>`,
    components:{MainNotification},
    router,
    store
})


$(document).ready(function(){

});

