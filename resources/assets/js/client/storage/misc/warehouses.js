/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainWarehouses from './MainWarehouses.vue'

const app =  new Vue({
    el:'#vc-storage-misc-warehouses',
    template:`<main-warehouses></main-warehouses>`,
    components:{MainWarehouses},
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-warehouses-box'),
        itemSelector: ".filter-item-warehouses"
    });
});

