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
        if (payload.feedData) {
            if (!_.find(state.liveClockInFeeds, payload.feedData)) { //make sure it does not exist already
                state.liveClockInFeeds.unshift(payload.feedData)
            }
        }
    },
    newClockOutFeed({commit, state}, payload){
        if (payload.feedData) {
            if (!_.find(state.liveClockOutFeeds, payload.feedData)) { //make sure it does not exist already
                state.liveClockOutFeeds.unshift(payload.feedData)
            }
        }
    }
}