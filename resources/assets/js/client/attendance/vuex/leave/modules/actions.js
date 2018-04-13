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
            type:'getLeaveSchedules',
            sortYear:'',
            leaveApprovalId:'',
            leaveTypeId:'',
            divisionId:''
        })
    },
    sorLeaveSchedule({commit,state},payload){

        commit({
            type:'getLeaveSchedules',
            sortYear:payload.sortYear,
            leaveApprovalId:payload.sortLeaveApprovalId,
            leaveTypeId:payload.sortLeaveTypeId,
            divisionId:payload.sortDivisionId
        })
    }

}