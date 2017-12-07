/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/slots/Index.vue'
import DetailSlot from '../views/slots/DetailSlot.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/detail/:id/slot',component:DetailSlot,name:'detailSlot'}
    ]
})

export default router
