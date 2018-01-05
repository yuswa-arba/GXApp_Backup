/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}){
        commit('getLiveFeedData')
    },
    newClockInFeed({commit, state}, payload){
        if(payload.feedData){
            state.liveClockInFeeds.unshift(payload.feedData)
        }
    },
    newClockOutFeed({commit, state}, payload){
        if(payload.feedData){
            state.liveClockOutFeeds.unshift(payload.feedData)
        }
    }
}