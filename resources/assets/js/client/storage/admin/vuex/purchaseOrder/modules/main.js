/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        requisitions: [],
        selectedRequisition: {},
        suppliers: [],
        currencies:[],
        unitOfMeasurements:[],
        selectedSupplier: {},
        items: [],
        itemToBeInserted: {
            itemDetail: {},
            amount:'',
            hasCustomUnit:0,
            customUnit:'',
            unitId:'',
            price:'',
            currencyFormat:'IDR'
        },
        POFormObject: {
            supplierId: '',
            requisitionId: '',
            approvalNumber: '',
            withRequisition: 1,
            withTaxInvoice: 0,
            npwpNo: '',
            npwpPhoto: '',
            taxFee: '',
            shippingFee: '',
            total: '',
            notes: ''
        },
        POItems: [],
        POFormIsFinishAndValid: false
    },
    getters,
    mutations,
    actions
}