/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/entry/Index.vue'
import PurchaseOrderDetail from '../views/entry/PurchaseOrderDetail.vue'
import ApprovalDetail from '../views/entry/ApprovalDetail.vue'
Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/detail/:id',component:PurchaseOrderDetail,name:'PODetail'},
        {path:'/approval/detail/:approvalNo',component:ApprovalDetail,name:'approvalDetail'}

    ]
})

export default router
