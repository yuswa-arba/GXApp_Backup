/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/purchaseOrder/Index.vue'
import PurchaseOrderForm from '../views/purchaseOrder/PurhcaseOrderForm.vue'
import PurchaseOrderDetail from '../views/purchaseOrder/PurchaseOrderDetail.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path:'/create/new',component:PurchaseOrderForm,name:'createNewPO'},
        {path:'/detail/:id',component:PurchaseOrderDetail,name:'PODetail'}
    ]
})

export default router
