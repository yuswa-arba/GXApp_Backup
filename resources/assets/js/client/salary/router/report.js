/**
 * Created by kevinpurwono on 23/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/report/Index.vue'
import AttemptGenerate from '../views/report/AttemptGenerate.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path:'/',component:Index},
        {path:'/attempt/generate',component:AttemptGenerate,name:'attemptGenerate'}
    ]
})

export default router
