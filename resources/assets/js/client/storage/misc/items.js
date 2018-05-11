/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainItems from './MainItems.vue'
import {store} from './vuex/items/store'

const app =  new Vue({
    el:'#vc-storage-misc-items',
    template:`<main-items></main-items>`,
    components:{MainItems},
    store
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-items-box'),
        itemSelector: ".filter-item-item"
    });
});

