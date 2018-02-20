/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/user'
import MainUser from './MainUser.vue'

const app =  new Vue({
    el:'#vc-user-profile',
    template:`<main-user></main-user>`,
    components:{MainUser},
    router
})


$(document).ready(function(){

});

