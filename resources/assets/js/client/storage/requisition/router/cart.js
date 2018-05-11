/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/cart/Index.vue'
import RequisitionForm from'../views/cart/RequisitionForm.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path: '/form', component:RequisitionForm,name:'requisitionForm'}
    ]
})

export default router
