/**
 * Created by kevinpurwono on 8/12/17.
 */
export default{
    jobPositions(state){
        return state.jobPositions
    },
    slotMakers(state){
        return state.slotMakers
    },
    slots(state){
        return state.slots
    },
    shifts(state){
        return state.shifts
    },
    employeesToBeAssigned(state){
        return state.employeesToBeAssigned
    },
    slotDetail(state){
        return state.slotDetail
    },
    calendarEventSource(state){
        return state.calendarEventSource
    },
    cbMappingSlots(state){
        return state.cbMappingSlots
    },
    slotsBeingMap(state){
        return state.slotsBeingMap
    },
    shiftMapPalette(state){
        return state.shiftMapPalette
    },
    cbSlotsBeingMap(state){
        return state.cbSlotsBeingMap
    },
    dateStartToAssign(state){
        return state.dateStartToAssign
    },
    dateEndToAssign(state){
        return state.dateEndToAssign
    },
    selectedShiftDetail(state){
        return state.selectedShiftDetail
    },
    defaultCopiedSlotName(state){
        return state.copyFromSlotName+'_copy'
    }
}