/**
 * Created by kevinpurwono on 28/12/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/face/Index.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index}
    ]
})

export default router
