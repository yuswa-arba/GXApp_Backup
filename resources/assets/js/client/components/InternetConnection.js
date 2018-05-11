/**
 * Created by kevinpurwono on 6/12/17.
 */
// require('../../bootstrap')

import Vue from 'vue'
import InternetConnection from './InternetConnection.vue'

const app = new Vue({
    el:'#vc-internet-connection',
    template:`<internet-connection></internet-connection>`,
    components:{InternetConnection},
})




