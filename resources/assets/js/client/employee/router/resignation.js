/**
 * Created by kevinpurwono on 9/11/17.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../views/resignation/Index.vue'
import List from '../views/resignation/List.vue'
import DetailMaster from '../views/resignation/DetailMaster.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    // mode: 'history',
    routes: [
        {path: '/', component: Index},
        {path: '/list', component: List},
        {path: '/detail/:id/master', component: DetailMaster, name: 'detailMaster'},

    ]
})

export default router
