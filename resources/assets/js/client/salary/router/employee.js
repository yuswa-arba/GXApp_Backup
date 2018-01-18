/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/employee/Index.vue'
import DetailSalary from '../views/employee/DetailSalary.vue'


Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/detail/:id',component:DetailSalary,name:'detailSalary'},
    ]
})

export default router
