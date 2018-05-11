/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/entry'
import MainEntry from './MainEntry.vue'
import {store} from './vuex/entry/store'

const app =  new Vue({
    el:'#vc-storage-inventory-entry',
    template:`<main-entry></main-entry>`,
    components:{MainEntry},
    router,
    store
})


$(document).ready(function(){

});

