/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/Index.vue'
import DetailMaster from '../views/DetailMaster.vue'
import DetailEmployment from '../views/DetailEmployment.vue'
import DetailLogin from '../views/DetailLogin.vue'

import EditMaster from '../views/EditMaster.vue'
import EditEmployment from '../views/EditEmployment.vue'
import EditLogin from '../views/EditLogin.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path:'/',component:Index},
        {path:'detail/:id/master',component:DetailMaster,name:'detailMaster'},
        {path:'detail/:id/employment',component:DetailEmployment,name:'detailEmployment'},
        {path:'detail/:id/login',component:DetailLogin,name:'detailLogin'},
        {path:'detail/:id/master/edit',component:EditMaster,name:'editMaster'},
        {path:'detail/:id/employment/edit',component:EditEmployment,name:'editEmployment'},
        {path:'detail/:id/login/edit',component:EditLogin,name:'editLogin'}
    ]
})

export default router
