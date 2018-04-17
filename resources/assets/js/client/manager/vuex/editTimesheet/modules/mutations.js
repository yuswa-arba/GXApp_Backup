/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
import router from 'vue-router'
export default{
    getTimesheetList(state, payload){
        get(api_path + 'manager/timesheet/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    //insert to array
                    state.timesheets = res.data.timesheets.data
                }
            })
    },
    getTimesheetSummaryData(state, payload){
        get(api_path + 'manager/timesheet/summary?editTimesheetId='+payload.editTimesheetId)
            .then((res) => {

                if (!res.data.isFailed) {
                    state.timesheetSummaryData = res.data.summary
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
    getShifts(state, payload){
        get(api_path + 'component/list/shifts')
            .then((res) => {
                state.shifts = res.data.data
            })
    },
    approveTimesheetFromSummary(state, timesheetId){
        post(api_path + 'attendance/timesheet/approve', {timesheetId: timesheetId})
            .then((res) => {
                if (!res.data.isFailed) {

                    /* Update timesheet sumamry data*/
                    _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                        _.forEach(value['timesheet'], function (value, medKey) {
                            _.forEach(value['detail']['data'], function (value, key) {
                                if (value['id'] == timesheetId) {
                                    let timesheetNewData = state.timesheetSummaryData[parentKey];
                                    timesheetNewData.timesheet[medKey].detail.data[0].attendanceApproveId = 1
                                    timesheetNewData.timesheet[medKey].detail.data[0].attendanceApproveName = 'Manager Approved'
                                }
                            })
                        })
                    })


                    // timesheetSumData.attendanceApproveId = 1
                    // timesheetSumData.attendanceApproveName = 'Manager Approved'
                    // state.timesheetSummaryData.splice(timesheetSumDataIndex,1,timesheetSumData)


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
    disapproveTimesheetFromSummary(state, timesheetId){
        post(api_path + 'attendance/timesheet/disapprove', {timesheetId: timesheetId})
            .then((res) => {
                if (!res.data.isFailed) {

                    /* Update timesheet sumamry data*/
                    _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                        _.forEach(value['timesheet'], function (value, medKey) {
                            _.forEach(value['detail']['data'], function (value, key) {
                                if (value['id'] == timesheetId) {
                                    let timesheetNewData = state.timesheetSummaryData[parentKey];
                                    timesheetNewData.timesheet[medKey].detail.data[0].attendanceApproveId = 98
                                    timesheetNewData.timesheet[medKey].detail.data[0].attendanceApproveName = 'Disapproved'
                                }
                            })
                        })
                    })

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
    saveTimesheet(state, payload){
        post(api_path + 'attendance/timesheet/update', {
            timesheetId: payload.timesheetId,
            clockInTime: payload.clockInTime,
            clockOutTime: payload.clockOutTime,
            shiftId: payload.shiftId,
            date: payload.date
        })
            .then((res) => {
                console.log(JSON.stringify(res.data.timesheet.data))
                if (!res.data.isFailed) {

                    /* Update timesheet summary data*/
                    _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                        _.forEach(value['timesheet'], function (value, medKey) {
                            _.forEach(value['detail']['data'], function (value, key) {
                                if (value['id'] == payload.timesheetId) {
                                    /* Update data */
                                    state.timesheetSummaryData[parentKey].timesheet[medKey].detail.data.splice(0, 1, res.data.timesheet.data)
                                }
                            })
                        })
                    })

                    /* Success notification */
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
    createTimesheet(state, payload){
        post(api_path + 'attendance/timesheet/createManually', {
            employeeId: payload.employeeId,
            timesheetId: payload.timesheetId,
            clockInTime: payload.clockInTime,
            clockOutTime: payload.clockOutTime,
            shiftId: payload.shiftId,
            date: payload.date
        })
            .then((res) => {
                if (!res.data.isFailed) {

                    /* Update timesheet summary data*/
                    _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                        if (value['employee']['data']['employeeNo'] == payload.employeeNo) {
                            let timesheetNewData = state.timesheetSummaryData[parentKey]
                            timesheetNewData.timesheet[payload.index].editing = false;
                            timesheetNewData.timesheet[payload.index].detail = {data: []};
                            timesheetNewData.timesheet[payload.index].detail.data.push(res.data.timesheet.data)
                        }
                    })

                    /* Success notification */
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
}