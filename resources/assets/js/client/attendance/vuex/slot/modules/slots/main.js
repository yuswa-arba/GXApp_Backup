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
        cbSlotsBeingMap: [],
        calendarShiftMappingEventSource: [],
        shiftMapPalette: [
            '336699',
            '00aaff',
            '6600ff',
            'ff00ff',
            'ff0080',
            '009999',
            '003399',
            '33334d',
            '13060d',
            '0d260d',
            '666633',
            '133913',
            'ff99ff',
            '99ff66',
            'b3b300',
            '737373',
            '00e6e6',
            '739900',
            'e60000',
            '000000',
            '0000ff',
            'ff0000',
            'ff8000',
            'ff5500',
            'ffff00',
            'aaff00',
            '666666',
            '660033',
            '33ccff',
            'b35900',
            '00ffcc',
            '800080',
            '669900',
            '2929a3',
            'cc00cc',
            '6b00b3',
            '1aff66',
            'ff6699',
            '0000b3',
            '009933',
            '7a00cc',
            'bf4080',
            '4d0000',
            '003366',
            '2a0080',
            '558000',
            '006666'
        ],
        dateStartToAssign:'',
        dateEndToAssign:''
    },
    getters,
    mutations,
    actions
}