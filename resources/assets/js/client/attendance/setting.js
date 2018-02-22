/**
 * Created by kevinpurwono on 8/11/17.
 */

require('lodash')

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

Vue.use(VueGoogleMaps, {
    load: {
        // key:'AIzaSyCRV00e8AjA3r4W3269xvjChOupfVDBz6U',
        key: '',
        libraries: 'places'
    }
})

const app = new Vue({
    el: '#vc-attendance-setting',
    template: `<main-setting></main-setting>`,
    components: {MainSetting},
    router
})


$(document).ready(function () {


    $('#workstart,#workend,#breakstart,#breakend').timepicker({showMeridian: false}).on('show.timepicker', function (e) {
        let widget = $('.bootstrap-timepicker-widget');
        widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
        widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
    });


    $('#holiday-datepicker-range').datepicker({format: 'dd/mm/yyyy',autoclose:true});

    $('.select2').select2();

    let settingDT = $('.settingDT');
    settingDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": false,
        "scrollCollapse": false,
        "ordering": false
    })

    let d = new Date();
    $('#firstdate').datepicker({
        format: 'dd/mm/yyyy',
        startDate: new Date(d.getFullYear(), 0, 1)
    });


    // disable mousewheel on a input number field when in focus
    // (to prevent Cromium browsers change the value when scrolling)
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('mousewheel.disableScroll', function (e) {
            e.preventDefault()
        })
    })

    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('mousewheel.disableScroll')
    })


})

