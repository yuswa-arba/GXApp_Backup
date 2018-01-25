/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getSalaryReportHistory(state, payload){

        get(api_path + 'salary/payroll/generateSalary/history')
            .then((res) => {

                if (!res.data.isFailed) {
                    state.salaryReportsHistory = res.data.reports
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
    getLastGeneratedPayroll(state, payload){
        get(api_path + 'salary/payroll/lastGeneratedPayroll')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.lastGeneratedPayroll = res.data.lastGeneratedPayroll
                }
            })
    },
    getPayrollList(state, payload){
        get(api_path + 'salary/payroll/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.generatedPayrollList = res.data.generatedPayrollList
                }
            })
    },
    getSalaryReportDetail(state, payload){



        get(api_path + 'salary/payroll/report/details/' + payload.id)
            .then((res) => {
                if (!res.data.isFailed) {

                    if (res.data.salaryReport) {
                        state.salaryReportDetails = res.data.salaryReport
                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: 'Salary Report is empty',
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
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

                state.isFetchingReportDetail = false

            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();

                state.isFetchingReportDetail = false

            })

    }

}