/**
 * Created by kevinpurwono on 6/12/17.
 */
import Vue from 'vue'
import router from './router/cart'
import MainCart from './MainCart.vue'
import {store} from './vuex/cart/store'

const app =  new Vue({
    el:'#vc-storage-requisition-cart',
    template:`<main-cart></main-cart>`,
    components:{MainCart},
    router,
    store
})


$(document).ready(function(){

});

