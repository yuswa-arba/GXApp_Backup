/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import router from './router/leave'
import MainLeave from './MainLeave.vue'

const app =  new Vue({
    el:'#vc-attendance-leave',
    template:`<main-leave></main-leave>`,
    components:{MainLeave},
    router
})


$(document).ready(function(){

    let leaveDT = $('.leaveDT');

    leaveDT.dataTable({
        "sDom": "t",
        "destroy": true,
        "paging": true,
        "scrollCollapse": false,
        "ordering": false
    })
    $('.dataTables_empty').hide();

});

