/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/timesheet/Index.vue'
import DetailTimesheet from '../views/timesheet/DetailTimesheet.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/detail/:id/',component:DetailTimesheet,name:'detailTimesheet'},

    ]
})

export default router
