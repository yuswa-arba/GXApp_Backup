/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
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

                if (!_.isEmpty(state.employeesToBeAssigned)) {
                    // show quickview if data is not empty
                    if (!$('#assignSlotQuickView').hasClass('open')) {
                        $('#assignSlotQuickView').addClass('open')
                    }
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
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 0,
                    type: 'danger'
                }).show();
            })
    },
    getSlotsDetail(state, slotId){
        get(api_path() + 'component/slot/' + slotId)
            .then((res) => {
                state.slotDetail = res.data.data
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
    },
    getCalendarEventSource(state, slotId){
        get(api_path() + 'attendance/slot/detail/calendar?' + 'slotId=' + slotId)
            .then((res) => {
                state.calendarEventSource = res.data.data
                $('#calendar').fullCalendar('addEventSource', state.calendarEventSource);

            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    },
    assignSlot(state, payload){
        post(api_path() + 'attendance/slot/assign/employee', {employeeId: payload.employeeId, slotId: payload.slotId})
            .then((res) => {
                if (!res.data.isFailed && res.data.employeeSlotData) {

                    const employeeData = res.data.employeeSlotData

                    const user = _.find(state.employeesToBeAssigned, {id: employeeData.employeeId})
                    const userIndex = _.findIndex(state.employeesToBeAssigned, user)

                    const slot = _.find(state.slots, {id: employeeData.slot.id})
                    const slotIndex = _.findIndex(state.slots, slot)

                    series([
                        function (callback) {

                            //update user object
                            user.hasSlotSchedule = true
                            user.slotSchedule = {id: employeeData.slot.id, name: employeeData.slot.name}

                            //update slot object


                            slot.assignedTo ={total: parseInt(slot.assignedTo.total) + 1,name:user.name}


                            if (!slot.allowMultipleAssign) {
                                slot.availableForAssign = false
                            }

                            //update user data in array
                            state.employeesToBeAssigned.splice(userIndex, 1, user)

                            //update slot data in arrray
                            state.slots.splice(slotIndex, 1, slot)

                            callback(null)
                        },
                        function (callback) {
                            /* Show success notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-left',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            callback(null)
                        },
                        function (callback) {

                            setTimeout(() => {
                                commit('register', userId)
                            }, 1000)

                            // $('#assignSlotQuickView').removeClass('open')

                            callback(null)
                        }
                    ])

                } else {
                    /* Show error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-left',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-left',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })


    }
}