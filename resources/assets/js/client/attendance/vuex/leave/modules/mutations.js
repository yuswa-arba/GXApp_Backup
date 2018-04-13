/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getDivisions(state, payload){
        get(api_path + 'component/list/divisions')
            .then((res) => {
                state.divisions = res.data.data
            })
    },
    getLeaveApprovals(state, payload){
        get(api_path + 'component/list/leaveApprovals')
            .then((res) => {
                state.leaveApprovals = res.data.data
            })
    },
    getLeaveTypes(state, payload){
        get(api_path + 'component/list/leaveTypes')
            .then((res) => {
                state.leaveTypes = res.data.data
            })
    },
    getLeaveSchedules(state, payload){
        get(api_path + 'attendance/leave/list?sortYear=' + payload.sortYear +
            '&leaveApprovalId=' + payload.leaveApprovalId + '&leaveTypeId=' + payload.leaveTypeId +
            '&divisionId=' + payload.divisionId
        )
            .then((res) => {
                state.leaveSchedules = res.data.data
            })
    }

}