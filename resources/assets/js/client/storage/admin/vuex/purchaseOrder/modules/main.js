/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        requisitions:[],
        selectedRequisition:{},
        suppliers:[],
        selectedSupplier:{},
        preFormObject: {
            supplierId: '',
            requisitionId: '',
            approvalNumber: '',
            withRequisition: 1,
            withTaxInvoice: 0,
            npwpNo: '',
            npwpPhoto: '',
            notes: ''
        },
        preFormIsFinishAndValid: false
    },
    getters,
    mutations,
    actions
}