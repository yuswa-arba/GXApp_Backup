/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/payroll/Index.vue'
import SalaryReportList from '../views/payroll/SalaryReportList.vue'
import SalaryReportDetail from '../views/payroll/SalaryReportDetail.vue'
import AttemptGenerate from '../views/payroll/AttemptGenerate.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/report/list',component:SalaryReportList,name:'salaryReportList'},
        {path:'/report/:id/detail',component:SalaryReportDetail,name:'salaryReportDetail'},
        {path:'/attempt/generate',component:AttemptGenerate,name:'attemptGenerate'}
    ]
})

export default router
