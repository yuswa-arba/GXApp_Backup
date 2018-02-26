/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import MainShipments from './MainShipments.vue'

const app =  new Vue({
    el:'#vc-storage-misc-shipments',
    template:`<main-shipments></main-shipments>`,
    components:{MainShipments},
})


$(document).ready(function(){

});

