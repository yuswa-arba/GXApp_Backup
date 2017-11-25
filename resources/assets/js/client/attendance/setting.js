/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue';
import * as VueGoogleMaps from 'vue2-google-maps'
import router from './router/setting'
import MainSetting from './MainSetting.vue'

// Create a global Event Bus
let EventBus = new Vue()

// Add to Vue properties by exposing a getter for $bus
Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return EventBus;
        }
    }
})

Vue.use(VueGoogleMaps,{
    load:{
        // key:'AIzaSyCRV00e8AjA3r4W3269xvjChOupfVDBz6U',
        key:'',
        libraries:'places'
    }
})

const app = new Vue({
    el: '#vc-attendance-setting',
    template: `<main-setting></main-setting>`,
    components: {MainSetting},
    router
})


$(document).ready(function () {


    $('#timestart').timepicker({showMeridian: false}).on('show.timepicker', function (e) {
        let widget = $('.bootstrap-timepicker-widget');
        widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
        widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
    });

    $('#timeend').timepicker({showMeridian: false}).on('show.timepicker', function (e) {
        let widget = $('.bootstrap-timepicker-widget');
        widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
        widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
    });

    $('#holiday-datepicker-range').datepicker({format: 'dd/mm/yyyy'});

    $('.select2').select2();

    let settingDT = $('.settingDT');
    settingDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": false,
        "scrollCollapse": false
    })

})

