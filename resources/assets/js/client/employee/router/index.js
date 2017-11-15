/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/Index.vue'
import Detail from '../views/Detail.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path:'/',component:Index},
        {path:'detail/:id',component:Detail,name:'detail'}
    ]
})

export default router
