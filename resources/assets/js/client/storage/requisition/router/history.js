/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/history/Index.vue'
import RequisitionTrackDetail from '../views/history/RequisitionTrackDetail.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/:search',component:Index},
        {path:'/track/detail/:id',component:RequisitionTrackDetail,name:'requisitionTrackDetail'}

    ]
})

export default router
