/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/employee/Index.vue'
import DetailSalary from '../views/employee/DetailSalary.vue'
import EditSalary from '../views/employee/EditSalary.vue'
import HistorySalary from '../views/employee/HistorySalary.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/detail/:id',component:DetailSalary,name:'detailSalary'},
        {path:'/detail/:id/edit',component:EditSalary,name:'editSalary'},
        {path:'/detail/:id/history',component:HistorySalary,name:'historySalary'}

    ]
})

export default router
