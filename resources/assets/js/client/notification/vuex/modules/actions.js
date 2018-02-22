/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{

    initConfigsFirstTIme({commit,state},payload){
        commit('listenToPersonalNotification')
    },

    getDataOnCreate({commit,state},payload){
      commit('getNotificationList')
    }
}