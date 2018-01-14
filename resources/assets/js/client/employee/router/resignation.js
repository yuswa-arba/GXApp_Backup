/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/resignation/Index.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index}
    ]
})

export default router
