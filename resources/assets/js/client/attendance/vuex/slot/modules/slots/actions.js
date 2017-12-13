/**
 * Created by kevinpurwono on 8/12/17.
 */

export default{
    getDataOnCreate({commit}){
        commit('getJobPositions')
        commit('getSlotMakers')
        commit({
            type: 'getSlots',
            statusById: '',
            relatedById: ''
        })

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
    removeSlotFromEmployee({commit,state},payload){
        commit({type: 'removeSlot', employee: payload.employee, slot: payload.slot})
    },
    attempShiftMapping({commit,state},payload){
        $('#modal-attempt-shift-mapping').modal('show')
    },
    getSlotsMapping({commit,state},payload){

        if(payload.by =='withSameParent'){
            state.cbMappingSlots = _.filter(state.slots,{slotMaker:{id:payload.slotMakerId,jobPositionId:payload.jobPositionId}})
        } else {
            state.cbMappingSlots = _.filter(state.slots,{slotMaker:{jobPositionid:payload.jobPositionId}})
        }

    }

}