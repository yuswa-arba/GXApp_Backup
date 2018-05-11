/**
 * Created by kevinpurwono on 28/12/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/queueJob/Index.vue'
import FailedJobs from '../views/queueJob/FailedJobs.vue'
Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/failedJobs',component:FailedJobs}
    ]
})

export default router
