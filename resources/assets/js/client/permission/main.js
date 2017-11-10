/**
 * Created by kevinpurwono on 8/11/17.
 */

import Vue from 'vue';
// import router from './router'

Vue.component('roles-card', require('./components/RolesCard.vue'));
Vue.component('permissions-card',require('./components/PermissionCard.vue'));

const app = new Vue({
    el: '#vc-role-permission',
})




$(document).ready(function(){
    $('#btn-new-role').on('click', function () {
        $('#modal-new-role').modal("show");
    });

    $('#btn-new-permission').on('click', function () {
        $('#modal-new-permission').modal("show");
    });


    $('.btn-vd-user').on('click', function () {
        $('#modal-permission-detail').modal("show");
    });
})

