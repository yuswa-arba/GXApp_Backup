/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
import router from 'vue-router'
export default{
    searchEmployee(state, payload){

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
    getNotificationGroupType(state, payload){
        let self = this
        get(api_path + 'component/list/notificationGroupTypes')
            .then((res) => {
                state.notificationGroupTypes = res.data.data
            })
    },
    getNotificationRecipient(state, payload){
        let self = this
    },
    createGroupType(state, payload){
        let self = this

        if(payload.name){
            post(api_path + 'setting/notification/groupType/create',{name:payload.name})
                .then((res) => {
                    if (!res.data.isFailed) {

                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'info'
                        }).show();

                        if(res.data.groupType.data){
                            //insert to array
                            state.notificationGroupTypes.push(res.data.groupType.data)
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
        }



    }
}