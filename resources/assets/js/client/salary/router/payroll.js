/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/payroll/Index.vue'
import SalaryReportList from '../views/payroll/SalaryReportList.vue'
import SalaryReportDetail from '../views/payroll/SalaryReportDetail.vue'
import AttemptGenerate from '../views/payroll/AttemptGenerate.vue'
import GeneratePayroll from '../views/payroll/GeneratePayroll.vue'
import LastPayrollDetail from '../views/payroll/LastPayrollDetail.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/report/list',component:SalaryReportList,name:'salaryReportList'},
        {path:'/report/:id/detail',component:SalaryReportDetail,name:'salaryReportDetail'},
        {path:'/report/:id/lastPayroll',component:LastPayrollDetail,name:'lastPayrollDetail'},
        {path:'/attempt/generate/:id',component:AttemptGenerate,name:'attemptGenerate'},
        {path:'/generate/:id',component:GeneratePayroll,name:'generate'}
    ]
})

export default router
