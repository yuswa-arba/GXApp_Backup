/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/Index.vue'
import DetailMaster from '../views/DetailMaster.vue'
import DetailEmployment from '../views/DetailEmployment.vue'
import DetailLogin from '../views/DetailLogin.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path:'/',component:Index},
        {path:'detail/:id/master',component:DetailMaster,name:'detailMaster'},
        {path:'detail/:id/employment',component:DetailEmployment,name:'detailEmployment'},
        {path:'detail/:id/login',component:DetailLogin,name:'detailLogin'}
    ]
})

export default router
