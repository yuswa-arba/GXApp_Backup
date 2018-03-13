/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/purchaseOrder'
import MainPurchaseOrder from './MainPurchaseOrder.vue'
import {store} from './vuex/purchaseOrder/store'

const app =  new Vue({
    el:'#vc-storage-admin-purchase-order',
    template:`<main-purchase-order></main-purchase-order>`,
    components:{MainPurchaseOrder},
    router,
    store
})


$(document).ready(function(){

});

