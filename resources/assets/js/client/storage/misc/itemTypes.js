/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainItemTypes from './MainItemTypes.vue'

const app =  new Vue({
    el:'#vc-storage-misc-itemTypes',
    template:`<main-item-types></main-item-types>`,
    components:{MainItemTypes},
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-types-box'),
        itemSelector: ".filter-item-types"
    });
});

