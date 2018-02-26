/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainItemCategories from './MainItemCategories.vue'

const app =  new Vue({
    el:'#vc-storage-misc-itemCategories',
    template:`<main-item-categories></main-item-categories>`,
    components:{MainItemCategories},
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-categories-box'),
        itemSelector: ".filter-item-categories"
    });
});

