/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{

    getSalaryQueueList(state, payload){
        get(api_path + 'salary/queue/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.salaryQueues  = res.data.salaryQueues.data
                }
            })
            .catch((err) => {

            })
    },
    searchEmployee(state,payload){

        let self = this
        if (payload.searchText) {
            get(api_path + 'employee/search/' + payload.searchText)
                .then((res) => {
                    if (!res.data.isFailed) {
                        if (res.data.candidates.data) {
                            state.employeeCandidates = res.data.candidates.data
                        }
                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }
                })
                .catch((err) => {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                })
        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: "Search box cannot be empty",
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }


    },

}