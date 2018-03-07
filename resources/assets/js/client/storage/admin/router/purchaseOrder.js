/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/purchaseOrder/Index.vue'
import PurchaseOrderForm from '../views/purchaseOrder/PurhcaseOrderForm.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path:'/create/new',component:PurchaseOrderForm,name:'createNewPO'}
    ]
})

export default router
