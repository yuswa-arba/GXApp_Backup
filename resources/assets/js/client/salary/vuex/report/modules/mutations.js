/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{

    getBranchOffices(state, payload){
        get(api_path + 'component/list/branchOffices')
            .then((res) => {
                state.branchOffices = res.data.data
            })
    },
    getGeneratedSalaryLogs(state, payload){
        get(api_path + 'salary/generate/logs')
            .then((res) => {
                state.generatedSalaryLogs = res.data.data
            })
    },
    getDefaultGenerateDate(state, payload){
        get(api_path + 'salary/payrollSetting/defaultGenerateDate')
            .then((res) => {
                state.defaultFromDate = res.data.fromDate
                state.defaultToDate = res.data.toDate
            })
    },
    getSalaryLogDetails(state, payload){
        if (payload.generateSalaryLogId) {
            get(api_path + 'salary/generate/logs/detail/' + payload.generateSalaryLogId)
                .then((res) => {

                    if (!res.data.isFailed) {

                        state.salaryLogDetails = res.data.salaryLogDetails.data

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
    },
    getAttemptGenerateSalaryData(state, payload){

        let fromDate = payload.fromDate
        let toDate = payload.toDate
        let branchOfficeId = payload.branchOfficeId

        get(api_path + 'salary/generate/attempt?fromDate=' + fromDate + '&toDate=' + toDate + '&branchOfficeId=' + branchOfficeId)
            .then((res) => {
                if (!res.data.isFailed) {

                    state.attemptGenerateSalaryData = res.data.salaryReport
                    state.isFetchingSalaryData = false
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
    generateSalaryNow(state, payload){

        let fromDate = payload.fromDate
        let toDate = payload.toDate
        let branchOfficeId = payload.branchOfficeId

        post(api_path + 'salary/generate', {fromDate: fromDate, toDate: toDate, branchOfficeId: branchOfficeId})
            .then((res) => {
                if (!res.data.isFailed) {

                    state.isGeneratingSalary = false
                    state.isGenerateSalarySuccessful = true

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