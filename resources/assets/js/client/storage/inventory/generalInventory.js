/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/generalInventory'
import MainGeneralInventory from './MainGeneralInventory.vue'
import {store} from './vuex/generalInventory/store'

const app =  new Vue({
    el:'#vc-storage-inventory-general',
    template:`<main-general-inventory></main-general-inventory>`,
    components:{MainGeneralInventory},
    router,
    store
})


$(document).ready(function(){

});

