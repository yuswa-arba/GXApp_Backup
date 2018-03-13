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
    $('#estimated-time-arrival').timepicker({showMeridian: false}).on('show.timepicker', function (e) {
        let widget = $('.bootstrap-timepicker-widget');
        widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
        widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
    });
    $('#estimated-date-arrival').datepicker({format: 'dd/mm/yyyy',autoclose:true});
});

