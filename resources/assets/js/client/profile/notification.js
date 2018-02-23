/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainNotification from './MainNotification.vue'

const app =  new Vue({
    el:'#vc-detail-notifications',
    template:`<main-notification></main-notification>`,
    components:{MainNotification},
})


$(document).ready(function(){

});

