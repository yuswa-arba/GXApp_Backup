/**
 * Created by kevinpurwono on 8/11/17.
 */

require('../../bootstrap') // axios,lodash,etc
window.Vue = require('vue');
window.VueRouter = require('vue-router');


const app = new Vue({
    el: '.content',
    data: {
        roles: [
            {name: 'asdf'},
            {name: 'zxcv'}
        ]
    }
})

