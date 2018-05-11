/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
import router from 'vue-router'
export default{
    getDivisions(state, payload){
        get(api_path + 'component/list/divisions')
            .then((res) => {
                state.divisions = res.data.data
            })
    },
    getBranchOffices(state, payload){
        get(api_path + 'component/list/branchOffices')
            .then((res) => {
                state.branchOffices = res.data.data
            })
    },
    getManagers(state, payload){
        get(api_path + 'employee/managers/list')
            .then((res) => {
                state.managers = res.data.managers.data
            })
    },
    assignManager(state, payload){
        post(api_path + 'employee/managers/assign', payload.formObject)
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    // //push
                    // state.managers.push(res.data.manager.data)

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
    },
    activateManager(state, payload){
        post(api_path + 'employee/managers/activate', {'divisionManagerId': payload.divisionManagerId})
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

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
    },
    deactivateManager(state, payload){
        post(api_path + 'employee/managers/deactivate', {'divisionManagerId': payload.divisionManagerId})
            .then((res) => {
                if (!res.data.isFailed) {

                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

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
    },
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
}