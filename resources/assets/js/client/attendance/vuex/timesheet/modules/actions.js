/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit}){
        commit({type:'getDivisions',divisionId:''})
        commit({type:'getShifts',shiftId:''})

        let currentDate = moment().format('DD/MM/YYYY');
        commit({type:'getTimesheetData',sortDate:currentDate})
    },
    getSortedData({commit},payload){
        commit({
            type:'getTimesheetData',
            sortDate:payload.sortDate,
            divisionId:payload.divisionId,
            shiftId:payload.shiftId
        })
    }

}