/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit,state}){
        commit({type:'getDivisions',divisionId:''})
        commit({type:'getShifts',shiftId:''})
        commit({type:'getAttdApprovals',attdAprovalId:''})

        let currentDate = moment().format('DD/MM/YYYY');
        if(state.sortedDate){
            currentDate = state.sortedDate
        }
        commit({type:'getTimesheetData',sortDate:currentDate})
    },
    getSortedData({commit,state},payload){

        commit({
            type:'getTimesheetData',
            sortDate:payload.sortDate,
            divisionId:payload.divisionId,
            shiftId:payload.shiftId,
            attdApprovalId:payload.attdApprovalId
        })

        state.sortedDate = payload.sortDate
    }

}