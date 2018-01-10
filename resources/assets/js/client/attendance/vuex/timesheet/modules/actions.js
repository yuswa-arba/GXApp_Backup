/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}){
        commit({type: 'getDivisions', divisionId: ''})
        commit({type: 'getShifts', shiftId: ''})
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
    startGenerateSummary({commit, state}, payload){

        $('#modal-attempt-generate-summary').modal('hide')
        $('#modal-attempt-generate-inside-summary').modal('hide')


        state.generateFromDate = payload.fromDate
        state.generateToDate = payload.toDate

        commit({
            type: 'getTimesheetSummaryDataAll',
            fromDate: payload.fromDate,
            toDate: payload.toDate
        })

    },
    editTimesheet({commit, state}, payload){
        if (payload.employeeNo) {

            _.forEach(state.timesheetSummaryData,function(value,parentKey){
                if(value['employee']['data']['employeeNo'] == payload.employeeNo){
                    let timesheetNewData  = state.timesheetSummaryData[parentKey]
                    timesheetNewData.timesheet[payload.index].editing = true;
                }
            })

        }
    }

}