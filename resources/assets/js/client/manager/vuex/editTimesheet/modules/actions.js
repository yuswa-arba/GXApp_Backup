/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit,state},payload){
        commit('getTimesheetList')
    },
    editTimesheet({commit, state}, payload){
        if (payload.employeeNo) {

            _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                if (value['employee']['data']['employeeNo'] == payload.employeeNo) {
                    let timesheetNewData = state.timesheetSummaryData[parentKey]
                    timesheetNewData.timesheet[payload.index].editing = true;
                }
            })

        }
    },
    cancelEditTimesheet({commit, state}, payload){
        if (payload.employeeNo) {
            _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                if (value['employee']['data']['employeeNo'] == payload.employeeNo) {
                    let timesheetNewData = state.timesheetSummaryData[parentKey]
                    timesheetNewData.timesheet[payload.index].editing = false;
                }
            })
        }
    },
    saveEditTimesheet({commit, state}, payload){

        if (payload.employeeNo) {
            _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                if (value['employee']['data']['employeeNo'] == payload.employeeNo) {
                    let timesheetNewData = state.timesheetSummaryData[parentKey]
                    timesheetNewData.timesheet[payload.index].editing = false;
                }
            })
        }

        if (payload.timesheetId) {
            commit({
                type: 'saveTimesheet',
                timesheetId: payload.timesheetId,
                clockInTime: payload.clockInTime,
                clockOutTime: payload.clockOutTime,
                shiftId: payload.shiftId,
                date: payload.date
            });
        }
    },
    createNewTimesheet({commit, state}, payload){


        if (payload.employeeNo) {
            _.forEach(state.timesheetSummaryData, function (value, parentKey) {
                if (value['employee']['data']['employeeNo'] == payload.employeeNo) {
                    let timesheetNewData = state.timesheetSummaryData[parentKey]
                    timesheetNewData.timesheet[payload.index].editing = false;
                }
            })
        }

        commit({
            type: 'createTimesheet',
            index: payload.index,
            employeeNo: payload.employeeNo,
            employeeId: payload.employeeId,
            clockInTime: payload.clockInTime,
            clockOutTime: payload.clockOutTime,
            shiftId: payload.shiftId,
            date: payload.date
        });
    },
}