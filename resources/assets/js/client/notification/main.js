/**
 * Created by kevinpurwono on 6/12/17.
 */

import Vue from 'vue'
import ButtonNotification from'./ButtonNotification.vue'
import MainNotification from './MainNotification.vue'
import {store} from './vuex/store'

const app = new Vue({
    el: '#nav-and-notification',
    components: {
        'notification-btn': ButtonNotification,
        'quickview-notification': MainNotification
    },
    store
})



