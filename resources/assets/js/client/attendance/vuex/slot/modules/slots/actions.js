/**
 * Created by kevinpurwono on 8/12/17.
 */
export default{
    getDataOnCreate({commit}){
        commit('getJobPositions')
        commit({
            type:'getSlots',
            statusById:'',
            relatedById:''
        })
    },
    getDataOnAssignSlot({commit},slotId){
        commit('getEmployeesToBeAssigned',slotId)
        commit('getSlotsDetail',slotId)
    },
    getDataOnSlotCalendar({commit},slotId){
        commit('getSlotsDetail',slotId)
        commit('getCalendarEventSource',slotId)

    }
}