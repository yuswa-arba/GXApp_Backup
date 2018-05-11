/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}){
        commit('getDivisions')
        commit('getLeaveApprovals')
        commit('getLeaveTypes')
        commit({
            type: 'getLeaveSchedules',
            sortYear: '',
            leaveApprovalId: '',
            leaveTypeId: '',
            divisionId: ''
        })
    },
    sortLeaveSchedule({commit, state}, payload){

        commit({
            type: 'getLeaveSchedules',
            sortYear: payload.sortYear,
            leaveApprovalId: payload.sortLeaveApprovalId,
            leaveTypeId: payload.sortLeaveTypeId,
            divisionId: payload.sortDivisionId
        })
    },
    answerLeaveSchedule({commit, state}, payload){
        if (state.selectedLeaveRequestIds.length > 0 && payload.leaveApprovalId != null) {
            commit({
                type: 'answerLeaveSchedules',
                leaveApprovalId: payload.leaveApprovalId
            })
        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Leave cannot be empty',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }
    }

}