/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap'); // axio, vue , vue-router, lodash, etc

import Vue from 'vue';
// import router from './router'

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

Vue.component('roles-card', require('./components/RolesCard.vue'));
Vue.component('permissions-card',require('./components/PermissionCard.vue'));
Vue.component('user-card',require('./components/UserCard.vue'));
Vue.component('create-new-menus',require('./components/CreateNewMenus.vue'));

const app = new Vue({
    el: '#vc-role-permission',
})


