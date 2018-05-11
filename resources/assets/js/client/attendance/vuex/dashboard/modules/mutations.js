/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getLiveFeedData(state){
        get(api_path+'attendance/dashboard/livefeed')
            .then((res)=>{
                if(res.data){
                    state.liveClockInFeeds = res.data.in.data
                    state.liveClockOutFeeds = res.data.out.data
                }
            })
            .catch((err)=>{
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 0,
                    type: 'danger'
                }).show();
            })
    }
}