/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}){
        commit({type: 'getDivisions', divisionId: ''})
        commit({type: 'getShifts', shiftId: ''})
        commit('getBranchOffices')
        commit({type: 'getAttdApprovals', attdAprovalId: ''})

        let currentDate = moment().format('DD/MM/YYYY');
        if (state.sortedDate) {
            currentDate = state.sortedDate
        }
        commit({type: 'getTimesheetData', sortDate: currentDate})
    },
    getSortedData({commit, state}, payload){

        commit({
            type: 'getTimesheetData',
            sortDate: payload.sortDate,
            divisionId: payload.divisionId,
            branchOfficeId: payload.branchOfficeId,
            shiftId: payload.shiftId,
            attdApprovalId: payload.attdApprovalId
        })

        state.sortedDate = payload.sortDate
    },
    attemptGenerateSummary({commit, state}){
        $('#modal-attempt-generate-summary').modal('show')
    },
    attemptGenerateInsideSummary({commit, state}){
        $('#modal-attempt-generate-inside-summary').modal('show')
    },
    attemptSendToManagers({commit, state}){
        $('#modal-attempt-send-to-managers').modal('show')
    },
    startGenerateSummary({commit, state}, payload){

        $('#modal-attempt-generate-summary').modal('hide')
        $('#modal-attempt-generate-inside-summary').modal('hide')

        /* Get shifts if empty*/
        if (!state.shifts) {
            commit({type: 'getShifts', shiftId: ''})
        }

        state.generateFromDate = payload.fromDate
        state.generateToDate = payload.toDate
        state.generateBranchOfficeId = payload.branchOfficeId

        commit({
            type: 'getTimesheetSummaryDataAll',
            fromDate: payload.fromDate,
            toDate: payload.toDate,
            branchOfficeId: payload.branchOfficeId
        })

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
    sendSummaryToManagers({commit, state}, payload){

        if (payload.dueDate != '' && state.generateFromDate != ''
            && state.generateToDate != '' && state.generateBranchOfficeId != '') {

            let formObject = {
                dueDate: payload.dueDate,
                startDate: state.generateFromDate,
                endDate: state.generateToDate,
                branchOfficeId: state.generateBranchOfficeId
            }

            commit({
                type: 'sendSummaryToManagers',
                formObject: formObject
            })

        } else {

            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Unable to send timesheet to managers.',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();

            $('#modal-attempt-send-to-managers').modal('toggle')


        }

    }

}