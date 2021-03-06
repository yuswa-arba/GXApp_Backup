/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/list/Index.vue'
import DetailMaster from '../views/list/DetailMaster.vue'
import DetailMedicalRecords from '../views/list/DetailMedicalRecords.vue'
import DetailEmployment from '../views/list/DetailEmployment.vue'
import DetailFaceAPI from '../views/list/DetailFaceAPI.vue'
import DetailLogin from '../views/list/DetailLogin.vue'

import EditMaster from '../views/list/EditMaster.vue'
import EditMedicalRecords from '../views/list/EditMedicalRecords.vue'
import EditEmployment from '../views/list/EditEmployment.vue'
import EditLogin from '../views/list/EditLogin.vue'
import NotFound from '../../helpers/NotFound.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path: '/detail/:id/master', component: DetailMaster, name: 'detailMaster'},
        {path: '/detail/:id/medicalRecords', component: DetailMedicalRecords, name: 'detailMedicalRecords'},
        {path: '/detail/:id/employment', component: DetailEmployment, name: 'detailEmployment'},
        {path: '/detail/:id/faceAPI', component: DetailFaceAPI, name: 'detailFaceAPI'},
        {path: '/detail/:id/login', component: DetailLogin, name: 'detailLogin'},
        {path: '/detail/:id/master/edit', component: EditMaster, name: 'editMaster'},
        {path: '/detail/:id/medicalRecords/edit', component: EditMedicalRecords, name: 'editMedicalRecords'},
        {path: '/detail/:id/employment/edit', component: EditEmployment, name: 'editEmployment'},
        {path: '/detail/:id/login/edit', component: EditLogin, name: 'editLogin'},
        // {path:'*',component:NotFound}
    ]
})

export default router
