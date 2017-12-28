/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getJobPositions(state){
        get(api_path + 'component/list/jobPosition')
            .then((res) => {
                state.jobPositions = res.data.data
            })
    },
    getSlotMakers(state){
        get(api_path + 'component/list/slotMakers')
            .then((res) => {
                state.slotMakers = res.data.data
            })
    },
    getSlots(state, payload){
        const statusById = payload.statusById
        const relatedById = payload.relatedById

        get(api_path + 'attendance/slot/list?' + 'statusBy=' + statusById + '&relatedBy=' + relatedById)
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
    getShifts(state, payload){
        get(api_path + 'component/list/shifts')
            .then((res) => {
                state.shifts = res.data.data
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
        get(api_path + 'attendance/slot/assign/employee?slotId=' + slotId)
            .then((res) => {

                state.employeesToBeAssigned = res.data.data

                _.sortBy(state.employeesToBeAssigned, (employees) => {
                    return employees.hasSlotSchedule && employees.slotSchedule.id == slotId
                })


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
        get(api_path + 'component/slot/' + slotId)
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
        get(api_path + 'attendance/slot/detail/calendar?' + 'slotId=' + slotId)
            .then((res) => {
                $('#calendar').fullCalendar('addEventSource', res.data.dayOffs.data);
                $('#calendar').fullCalendar('addEventSource', res.data.shiftSchedules.data);
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
        post(api_path + 'attendance/slot/assign/employee', {employeeId: payload.employee.id, slotId: payload.slot.id})
            .then((res) => {
                if (!res.data.isFailed) {

                    const user = _.find(state.employeesToBeAssigned, {id: payload.employee.id})
                    const userIndex = _.findIndex(state.employeesToBeAssigned, user)

                    const slot = _.find(state.slots, {id: payload.slot.id})
                    const slotIndex = _.findIndex(state.slots, slot)

                    series([
                        function (callback) {

                            //update user object
                            user.hasSlotSchedule = true
                            user.slotSchedule = {id: payload.slot.id, name: payload.slot.name}

                            //update slot object
                            slot.assignedTo = {total: parseInt(slot.assignedTo.total) + 1, name: user.name}

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
    },
    removeSlot(state, payload){
        post(api_path + 'attendance/slot/remove/employee', {employeeId: payload.employee.id})
            .then((res) => {
                if (!res.data.isFailed) {

                    const user = _.find(state.employeesToBeAssigned, {id: payload.employee.id})
                    const userIndex = _.findIndex(state.employeesToBeAssigned, user)

                    const slot = _.find(state.slots, {id: user.slotSchedule.id})
                    const slotIndex = _.findIndex(state.slots, slot)

                    series([
                        function (callback) {

                            //update user object
                            user.hasSlotSchedule = false
                            user.slotSchedule = ''

                            //update slot object
                            if (parseInt(slot.assignedTo.total) > 0) {
                                slot.assignedTo = {total: parseInt(slot.assignedTo.total) - 1}
                            }

                            if (!slot.allowMultipleAssign) {
                                slot.availableForAssign = true
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
                                /* Show warning slot removed notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'Employee automatically assigned to default slot',
                                    position: 'top-left',
                                    timeout: 4500,
                                    type: 'warning'
                                }).show();
                            }, 2000)


                            callback(null)
                        }
                    ])


                } else { /* Show error notification */
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

    },
    getCalendarDataForMapping(state, payload){

        post(api_path + 'attendance/shift/mapping/calendar', {slotIds: payload.slotIds})
            .then((res) => {

                state.calendarShiftMappingEventSource = res.data.data

                //add color
                let c = 0
                _.forEach(payload.slotIds, function (value, key) {

                    let filteredToAddColor = _.filter(state.calendarShiftMappingEventSource, {slotId: value})
                    for (let i = 0; i < filteredToAddColor.length; i++) {
                        _.assign(filteredToAddColor[i], {backgroundColor: '#' + state.shiftMapPalette[c]})
                    }

                    c++ //increment
                })

                $('#calendar-shift-mapping').fullCalendar('addEventSource', state.calendarShiftMappingEventSource)


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
    getShiftSchedule(state, payload){

        post(api_path + 'attendance/shift/mapping/schedule', {slotIds: payload.slotIds})
            .then((res) => {
                state.calendarShiftScheduleEventSource = res.data.data
                //add color
                let c = 0
                _.forEach(payload.slotIds, function (value, key) {

                    let filteredToAddColor = _.filter(state.calendarShiftScheduleEventSource, {slotId: value})
                    for (let i = 0; i < filteredToAddColor.length; i++) {
                        _.assign(filteredToAddColor[i], {backgroundColor: '#' + state.shiftMapPalette[c]})
                    }

                    c++ //increment
                })
                $('#calendar-shift-mapping').fullCalendar('addEventSource', state.calendarShiftScheduleEventSource)

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
    mapShift(state, payload){

        state.isSavingShift = true

        post(api_path + 'attendance/shift/mapping', {
            slotId: payload.slotId,
            shiftId: payload.shiftId,
            dateStart: payload.dateStart,
            dateEnd: payload.dateEnd
        })
            .then((res) => {
                if (!res.data.isFailed) {
                    $('#modal-mapping-shift').modal('toggle')

                    /* Show success notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    state.isSavingShift = false

                } else {
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

            })
    },
    saveSlotUseMapping(state, payload){

        post(api_path + 'attendance/slot/edit/useMapping', {
            slotId: payload.slotId,
            isUsingMapping: payload.isUsingMapping
        })
            .then((res) => {
                if (!res.data.isFailed) {

                    /* Show success notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    const slot = _.find(state.slots, {id: payload.slotId})
                    const slotIndex = _.findIndex(state.slots, slot)

                    slot.isUsingMapping = payload.isUsingMapping

                    //update slot data in arrray
                    state.slots.splice(slotIndex, 1, slot)

                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
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
                    position: 'top',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })


    },
    removeShiftSchedule(state, payload){
        post(api_path + 'attendance/shift/remove/schedule', {id: payload.id})
            .then((res) => {
                if (!res.isFailed) {

                    /* Show success notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    $('#modal-shift-edit').modal('toggle') //close modal
                    $('#calendar-shift-mapping').fullCalendar('removeEvents', payload.id) //remove event

                } else {
                    /* Show error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            })
            .catch((err) => {
                /* Show error notification */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    },
    editShiftSchedule(state, payload){
        post(api_path + 'attendance/shift/edit/schedule', {id: payload.id, shiftId: payload.shiftId})
            .then((res) => {
                if (!res.isFailed && res.data.slotShiftData) {

                    /* Show success notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    $('#modal-shift-edit').modal('toggle') //close modal

                    const shiftEvent = _.find(state.calendarShiftScheduleEventSource, {id: payload.id})
                    const shiftEventIndex = _.findIndex(state.calendarShiftScheduleEventSource, shiftEvent)

                    //update slot shift data in array
                    let slotShiftData = res.data.slotShiftData.data
                    let calendarEvent = payload.calendarEvent

                    console.log(slotShiftData)

                    calendarEvent.title = slotShiftData.title
                    calendarEvent.shiftId = slotShiftData.shiftId
                    calendarEvent.start = slotShiftData.start
                    calendarEvent.end = slotShiftData.end


                    $('#calendar-shift-mapping').fullCalendar('updateEvent', calendarEvent); //add event

                    state.calendarShiftScheduleEventSource.splice(shiftEventIndex, 1, slotShiftData)


                } else {
                    /* Show error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            })
            .catch((err) => {
                /* Show error notification */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    }
}