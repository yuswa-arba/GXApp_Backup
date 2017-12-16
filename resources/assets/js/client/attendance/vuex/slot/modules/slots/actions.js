/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import until from 'async/until';
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
        //
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

        //insert slot data
        _.forEach(payload.slotIds, function (value, key) {

            // insert slots except the plucked ones
            if (!value.toString().startsWith('plucked_')) {
                state.slotsBeingMap.push(_.find(state.slots, {id: value}))
            }

            if (payload.refreshCb) {
                state.cbSlotsBeingMap.push(_.find(state.slots, {id: value}))
            }

        })

        commit({
            type: 'getCalendarDataForMapping',
            slotIds: payload.slotIds,
        })

        commit({
            type: 'getShiftSchedule',
            slotIds: payload.slotIds,
        })


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

                let slotIdsBeingMap = _.map(state.slotsBeingMap, 'id')

                setTimeout(function () {

                    _.forEach(filterShiftSchedule, function (value, key) {
                        $('#calendar-shift-mapping').fullCalendar('removeEvents', value.id)
                    })

                    commit({
                        type: 'getShiftSchedule',
                        slotIds: slotIdsBeingMap
                    })
                }, 2000)

                cb(null)
            }

        ], function (err, result) {
            //done
        })


    }

}