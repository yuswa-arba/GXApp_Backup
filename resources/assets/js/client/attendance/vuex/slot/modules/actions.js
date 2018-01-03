/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit}){
        commit('getJobPositions')
        commit('getSlotMakers')
        commit({
            type: 'getSlots',
            statusById: '',
            relatedById: ''
        })
        commit('getShifts')

    },
    getDataOnAssignSlot({commit}, slotId){
        commit('getEmployeesToBeAssigned', slotId)
        commit('getSlotsDetail', slotId)
    },
    getDataOnSlotCalendar({commit}, slotId){
        commit('getSlotsDetail', slotId)
        commit('getCalendarEventSource', slotId)
    },
    assignSlotToEmployee({commit, state}, payload){
        commit({type: 'assignSlot', employee: payload.employee, slot: payload.slot})
    },
    removeSlotFromEmployee({commit, state}, payload){
        commit({type: 'removeSlot', employee: payload.employee, slot: payload.slot})
    },
    attempShiftMapping({commit, state}, payload){
        $('#modal-attempt-shift-mapping').modal('show')
    },
    getSlotsMapping({commit, state}, payload){
        if (payload.by == 'withSameParent') {
            state.cbMappingSlots = _.filter(state.slots, {
                slotMaker: {
                    id: payload.slotMakerId,
                    jobPositionId: payload.jobPositionId
                }
            })
        } else {
            state.cbMappingSlots = _.filter(state.slots, {slotMaker: {jobPositionId: payload.jobPositionId}})
        }
    },
    startShiftMapping({commit, state}, payload){
        // reset data
        state.cbMappingSlots = []
        state.slotsBeingMap = []

        if (payload.refreshCb) {
            state.cbSlotsBeingMap = []
        }

        let currentAffectedCbIndex
        if (payload.affectedCbSlotId) {
            currentAffectedCbIndex = _.findIndex(state.cbSlotsBeingMap, {id: payload.affectedCbSlotId})
        }

        let slotIdsToGet = []

        //insert slot data
        _.forEach(payload.slotIds, function (value, key) {
            // insert slots except the plucked ones
            if (!value.toString().startsWith('plucked_')) {
                state.slotsBeingMap.push(_.find(state.slots, {id: value}))
                slotIdsToGet.push(value) // remove plucked ids to use in server request
            }

            if (payload.refreshCb) {
                state.cbSlotsBeingMap.push(_.find(state.slots, {id: value}))
            }
        })


        if (!_.isEmpty(slotIdsToGet)) {
            series([
                function (cb) {
                    //reset calendar
                    $('#calendar-shift-mapping').fullCalendar('removeEvents')
                    cb(null)
                },
                function (cb) {
                    commit({
                        type: 'getCalendarDataForMapping',
                        slotIds: slotIdsToGet,
                    })
                    cb(null)
                },
                function (cb) {
                    commit({
                        type: 'getShiftSchedule',
                        slotIds: slotIdsToGet,
                    })
                    cb(null)
                }
            ])

        } else {
            $('#calendar-shift-mapping').fullCalendar('removeEvents')

        }
    },
    attemptAssignShift({commit, state}, payload){

        // set state value
        state.dateStartToAssign = payload.dateStartToAssign
        state.dateEndToAssign = payload.dateEndToAssign

        $('#modal-mapping-shift').modal('show')

    },
    saveShiftMap({dispatch, commit, state}, payload){

        waterfall([
            function (cb) {
                commit({
                    type: 'mapShift',
                    slotId: payload.slotId,
                    shiftId: payload.shiftId,
                    dateStart: payload.dateStart,
                    dateEnd: payload.dateEnd
                })
                cb(null)

            },
            function (cb) {

                if (state.isSavingShift) {
                    /* Show please wait notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Refreshing data please wait...',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'success'
                    }).show();
                }

                // remove event before adding the new saved so its not duplicated
                let filterShiftSchedule = _.filter(state.calendarShiftScheduleEventSource, {eventType: 'shiftSchedule'})

                cb(null, filterShiftSchedule)
            },
            function (filterShiftSchedule, cb) {

                setTimeout(function () {

                    _.forEach(filterShiftSchedule, function (value, key) {
                        $('#calendar-shift-mapping').fullCalendar('removeEvents', value.id)
                    })

                    // prevent null
                    if(_.isEmpty(state.slotIdsBeingMapAndPlucked)){
                        state.slotIdsBeingMapAndPlucked = _.map(state.slotsBeingMap, 'id')
                    }

                    commit({
                        type: 'getShiftSchedule',
                        slotIds: state.slotIdsBeingMapAndPlucked
                    })
                }, 2000)

                cb(null)
            }

        ], function (err, result) {
            //done
        })


    },
    editSlotUseMapping({commit, state}, payload){
        commit({
            type: 'saveSlotUseMapping',
            slotId: payload.slotId,
            isUsingMapping: payload.isUsingMapping
        })
    },
    getShiftDetail({commit, state}, payload){
        state.selectedShiftDetail = _.find(state.shifts, {id: payload.shiftId})
        state.selectedShiftDetail.slotShiftScheduleId = payload.slotShiftScheduleId
        state.selectedCalendarEvent = payload.calendarEvent
    },
    removeShift({commit, state}, payload){
        commit({
            type: 'removeShiftSchedule',
            id: payload.id
        })
    },
    editShift({commit, state}, payload){

        series([
            function (cb) {
                commit({
                    type: 'editShiftSchedule',
                    id: payload.slotShiftScheduleId,
                    shiftId: payload.shiftId,
                    calendarEvent: state.selectedCalendarEvent
                })
                cb(null)
            },
            function (cb) {
                //reset
                state.selectedCalendarEvent = ''
                cb(null)
            }
        ])

    }

}