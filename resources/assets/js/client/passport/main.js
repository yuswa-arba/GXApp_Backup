/**
 * Created by kevinpurwono on 9/11/17.
 */

window.Vue = require('vue');
window.VueRouter = require('vue-router');

Vue.component(
    'passport-clients',
    require('./components/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#passport-content'
});
