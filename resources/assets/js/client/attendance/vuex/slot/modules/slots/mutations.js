/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'

export default{
    getJobPositions(state){
        get(api_path() + 'component/list/jobPosition')
            .then((res) => {
                state.jobPositions = res.data.data
            })
    },
    getSlots(state, payload){
        const statusById = payload.statusById
        const relatedById = payload.relatedById

        get(api_path() + 'attendance/slot/list?' + 'statusBy=' + statusById + '&relatedBy=' + relatedById)
            .then((res) => {
                state.slots = res.data.data

                // fix datatables Bug displaying "no data available"
                if (!_.isEmpty(state.slots)) {
                    $('.dataTables_empty').hide()
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
    getEmployeesToBeAssigned(state, slotId){
        get(api_path() + 'attendance/slot/assign/employee?slotId=' + slotId)
            .then((res) => {

                state.employeesToBeAssigned = res.data.data

                // show modal if data is not empty
                if (!_.isEmpty(state.employeesToBeAssigned)) {
                    $('#assignSlotModal').modal('show')
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: "Unable to find employees data for this slot. Try Again",
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            })
            .catch((err) => {

                // bug bootstrap modal error
                if (err.message != "Modal is transitioning") {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();
                }
            })
    },
    getSlotsDetail(state, slotId){
        get(api_path() + 'component/slot/' + slotId)
            .then((res) => {
                state.slotAssignModal = res.data.data
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