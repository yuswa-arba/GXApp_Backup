/**
 * Created by kevinpurwono on 6/12/17.
 */
require('../../bootstrap')

import Vue from 'vue'
import router from './router/setting'
import MainSetting from './MainSetting.vue'
import {store} from './vuex/setting/store'

const app =  new Vue({
    el:'#vc-salary-setting',
    template:`<main-setting></main-setting>`,
    components:{MainSetting},
    router,
    store
})


$(document).ready(function(){


});

