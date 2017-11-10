/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap') // axios,lodash,etc
import Vue from 'vue';
// import router from './router'

Vue.component('roles-card',require('./components/RolesCard.vue'));

const app = new Vue({
    el: '#vc-role-permission',

})

