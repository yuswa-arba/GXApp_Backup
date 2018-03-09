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
        itemToBeInserted: { // Make sure when change this, any reference to this object has to be updated as well
            withRequisitionItem:0,
            requisitionItemId:'',
            itemDetail: {},
            amount:'',
            hasCustomUnit:0,
            customUnit:'',
            unitId:'',
            unitFormat:'',
            price:'',
            currencyFormat:'IDR'
        },
        POFormObject: {
            supplierId: '',
            contactPerson:'',
            contactNumber:'',
            requisitionId: '',
            approvalNumber: '',
            withRequisition: 1,
            withTaxInvoice: 0,
            npwpNo: '',
            npwpPhoto: '',
            taxFee: 0,
            taxFeeAdded:0,//false
            shippingFee: 0,
            shippingFeeAdded:0,//false
            total: '',
            notes: '',
            currencyFormat:'IDR'
        },
        POItems: [],
        POFormIsFinishAndValid: false,
        isCreatingPurchaseOrder:false
    },
    getters,
    mutations,
    actions
}