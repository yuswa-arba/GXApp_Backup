/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{

    getDataOnCreate({commit,state},payload){
        commit('getApprovalStatusList')
    },

}