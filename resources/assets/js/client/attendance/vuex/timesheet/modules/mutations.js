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
    getTimesheetData(state, payload){
        let divisionId = ''
        let shiftId = ''
        let sortDate = ''

        if (payload.divisionId)
            divisionId = payload.divisionId

        if (payload.shiftId)
            shiftId = payload.shiftId

        if (payload.sortDate)
            sortDate = payload.sortDate

        get(api_path + 'attendance/timesheet/list?sortDate=' + sortDate + '&divisionId=' + divisionId + '&shiftId=' + shiftId)
            .then((res) => {
                if (res.data.data)
                    state.timesheetsData = res.data.data
            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 0,
                    type: 'danger'
                }).show();
            })
    }

}