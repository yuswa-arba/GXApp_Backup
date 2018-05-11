/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/shop'
import MainShop from './MainShop.vue'
import {store} from './vuex/shop/store'

const app =  new Vue({
    el:'#vc-storage-requisition-shop',
    template:`<main-shop></main-shop>`,
    components:{MainShop},
    router,
    store
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-items-box'),
        itemSelector: ".filter-item-item"
    });
});

