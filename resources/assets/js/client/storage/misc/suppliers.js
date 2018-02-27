/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainSuppliers from './MainSuppliers.vue'

const app =  new Vue({
    el:'#vc-storage-misc-suppliers',
    template:`<main-suppliers></main-suppliers>`,
    components:{MainSuppliers},
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-suppliers-box'),
        itemSelector: ".filter-item-suppliers"
    });
});

