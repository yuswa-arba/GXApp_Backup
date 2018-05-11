/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/editTimesheet/Index.vue'
import SummaryTimesheet from '../views/editTimesheet/SummaryTimesheet.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path:'/summary/:editTimesheetId',component:SummaryTimesheet,name:'timesheetSummary'}

    ]
})

export default router
