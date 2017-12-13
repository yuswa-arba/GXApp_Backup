/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        jobPositions: [],
        slotMakers: [],
        slots: [],
        employeesToBeAssigned: [],
        slotDetail: {},
        calendarEventSource: [],
        cbMappingSlots: [],
        slotsBeingMap: [],
        calendarShiftMappingEventSource: [],
        shiftMapPalette: palette('tol-rainbow', 25)
    },
    getters,
    mutations,
    actions
}