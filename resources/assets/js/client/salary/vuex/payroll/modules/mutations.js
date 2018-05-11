/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getSalaryReportHistory(state, payload){

        get(api_path + 'salary/payroll/generateSalary/history?year=' + payload.selectedYear + '&branchOfficeId=' + payload.branchOfficeId)
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
                })

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

                    if (res.data.salaryReportDetails) {
                        state.salaryReportDetails = res.data.salaryReportDetails
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

    },
    refreshSalaryReport(state, payload){

        post(api_path + 'salary/payroll/report/refresh/' + payload.id)
            .then((res) => {
                if (!res.data.isFailed) {


                    /// success notification
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    //refresh data
                    state.salaryReportsHistory.splice(payload.index, 1, res.data.reports)

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
    getAttemptGenerateSalaryReport(state, payload){
        if (payload.generateSalaryReportLogId) {
            get(api_path + 'salary/payroll/generate/attempt?generateSalaryReportLogId=' + payload.generateSalaryReportLogId)
                .then((res) => {
                    if (!res.data.isFailed) {

                        state.attemptGenerateSalaryReport = res.data.reports

                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }


                    state.isFetchingAttemptSalaryReportData = false
                })
                .catch((err) => {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();

                    state.isFetchingAttemptSalaryReportData = false
                })
        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Error! Salary Report Log ID is empty',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }
    },
    generatePayroll(state, payload){

        post(api_path + 'salary/payroll/generate', {
            generateSalaryReportLogId: payload.generateSalaryReportLogId,
            generateType: payload.generateType,
            transferDate: payload.transferDate,
            notes: payload.notes
        })
            .then((res) => {

                state.isStartGeneratingPayroll = false
                state.attemptGenerateType = '' //reset

                if (!res.data.isFailed) {

                    state.generatePayrollResponse.isFailed = false
                    state.generatePayrollResponse.message = res.data.message
                    state.generatedPayrollId = res.data.payrollId

                } else {

                    state.generatePayrollResponse.isFailed = true
                    state.generatePayrollResponse.message = res.data.message

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

                state.isStartGeneratingPayroll = false

                state.generatePayrollResponse.isFailed = true
                state.generatePayrollResponse.message = 'An Error Occurred'

                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();

            })
    },
    getLastPayrollDetail(state, payload){
        get(api_path + 'salary/payroll/lastPayroll/' + payload.id)
            .then((res) => {

                if (!res.data.isFailed) {

                    state.lastPayrollDetail = res.data.lastPayroll

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
    downloadFile(state, payload){
        if (payload.id) {

            window.open(api_path + 'salary/payroll/download/file/' + payload.id)

        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'ID is not defined',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }
    },
    deleteFile(state, payload){
        if (payload.id) {

            post(api_path + 'salary/payroll/delete/file/' + payload.id)
                .then((res) => {
                    if (!res.data.isFailed) {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'info'
                        }).show();

                        //remove from array
                        state.generatedPayrollList[payload.index].file = ''

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
                message: 'ID is not defined',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }
    }

}