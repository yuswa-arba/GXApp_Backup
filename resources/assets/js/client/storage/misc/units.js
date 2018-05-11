/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainUnits from './MainUnits.vue'

const app =  new Vue({
    el:'#vc-storage-misc-units',
    template:`<main-units></main-units>`,
    components:{MainUnits},
})


$(document).ready(function(){
    $('.filter-container').sieve({
        searchInput: $('#search-units-box'),
        itemSelector: ".filter-item-units"
    });
});

