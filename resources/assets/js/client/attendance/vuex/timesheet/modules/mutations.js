/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getDivisions(state, payload){

        if (!payload.divisionId) {
            get(api_path + 'component/list/divisions')
                .then((res) => {
                    state.divisions = res.data.data
                })
        } else {
            get(api_path + 'component/division/' + payload.divisionId)
                .then((res) => {
                    state.divisions = res.data.data
                })
        }

    },
    getShifts(state, payload){
        if (!payload.shiftId) {
            get(api_path + 'component/list/shifts')
                .then((res) => {
                    state.shifts = res.data.data
                })
        } else {
            get(api_path + 'component/shift/' + payload.shiftId)
                .then((res) => {
                    state.shifts = res.data.data
                })
        }
    },
    getAttdApprovals(state, payload){
        if (!payload.attdApprovalId) {
            get(api_path + 'component/list/attdApprovals')
                .then((res) => {
                    state.attdApprovals = res.data.data
                })
        } else {
            get(api_path + 'component/attdApproval/' + payload.attdApprovalId)
                .then((res) => {
                    state.attdApprovals = res.data.data
                })
        }
    },
    getTimesheetData(state, payload){
        let divisionId = ''
        let shiftId = ''
        let sortDate = ''
        let attdApprovalId = ''

        if (payload.divisionId)
            divisionId = payload.divisionId

        if (payload.shiftId)
            shiftId = payload.shiftId

        if (payload.sortDate)
            sortDate = payload.sortDate

        if (payload.attdApprovalId)
            attdApprovalId = payload.attdApprovalId

        get(api_path + 'attendance/timesheet/list?sortDate=' + sortDate + '&divisionId=' + divisionId + '&shiftId=' + shiftId + '&attdApprovalId=' + attdApprovalId)
            .then((res) => {
                if (res.data.data)
                    state.timesheetsData = res.data.data
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
    approveTimesheet(state, timesheetId){
        post(api_path + 'attendance/timesheet/approve', {timesheetId: timesheetId})
            .then((res) => {
                if (!res.data.isFailed) {
                    let timesheet = _.find(state.timesheetsData, {id: timesheetId})
                    let timesheetIndex = _.findIndex(state.timesheetsData, timesheet)

                    // Update data
                    timesheet.attendanceApproveId = 1
                    timesheet.attendanceApproveName = 'Manager Approved'
                    timesheet.approvedBy = res.data.approvedBy
                    state.timesheetsData.splice(timesheetIndex, 1, timesheet)

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
    disapproveTimesheet(state, timesheetId){
        post(api_path + 'attendance/timesheet/disapprove', {timesheetId: timesheetId})
            .then((res) => {
                if (!res.data.isFailed) {
                    let timesheet = _.find(state.timesheetsData, {id: timesheetId})
                    let timesheetIndex = _.findIndex(state.timesheetsData, timesheet)

                    // Update data
                    timesheet.attendanceApproveId = 98
                    timesheet.attendanceApproveName = 'Disapproved'
                    timesheet.approvedBy = res.data.approvedBy
                    state.timesheetsData.splice(timesheetIndex, 1, timesheet)

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
    getTimesheetSummaryDataAll(state, payload){
        get(api_path + 'attendance/timesheet/summary/all?' + 'fromDate=' + payload.fromDate + '&toDate=' + payload.toDate)
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
    }

}