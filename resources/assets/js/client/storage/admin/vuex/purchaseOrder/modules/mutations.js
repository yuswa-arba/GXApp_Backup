/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getNPWPInformation(state, payload){
        get(api_path + 'component/npwpInformation/1')
            .then((res) => {
                state.POFormObject.npwpNo = res.data.data.npwpNo
                state.POFormObject.npwpPhoto = res.data.data.npwpPhoto
            })
    },
    getCurrencies(state, payload){
        get(api_path + 'component/list/currencies')
            .then((res) => {
                state.currencies = res.data.data
            })
    },
    getUnitOfMeasurements(state, payload){
        get(api_path + 'storage/unit/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.unitOfMeasurements = res.data.units.data
                }
            })
    },
    getRequisitionList(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/requisition')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.requisitions.data) {

                        state.requisitions = []

                        //insert requisitions
                        let requisitionData = res.data.requisitions.data
                        if (requisitionData) {
                            state.requisitions = state.requisitions.concat(requisitionData)
                        }
                    }
                }
            })
    },
    searchRequisition(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/requisition/search?v=' + payload.searchRequisitionText)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.requisitions.data) {

                        state.requisitions = []

                        //insert requisitions
                        let requisitionData = res.data.requisitions.data
                        if (requisitionData) {
                            state.requisitions = state.requisitions.concat(requisitionData)
                        }
                    }
                }
            })
    },
    getSupplierList(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/supplier')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.suppliers.data) {

                        state.suppliers = []

                        //insert suppliers
                        let suppliersData = res.data.suppliers.data
                        if (suppliersData) {
                            state.suppliers = state.suppliers.concat(suppliersData)
                        }

                    }
                }
            })
    },
    searchSupplier(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/supplier/search?v=' + payload.searchSupplierText)
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.suppliers.data) {

                        state.suppliers = []

                        //insert suppliers
                        let suppliersData = res.data.suppliers.data
                        if (suppliersData) {
                            state.suppliers = state.suppliers.concat(suppliersData)
                        }

                    }
                }
            })
    },
    searchItems(state, payload){
        get(api_path + 'storage/admin/purchaseOrder/item/search?v=' + payload.searchItemText)
            .then((res) => {

                //reset item
                state.items = []

                if (!res.data.isFailed) {
                    if (res.data.items.data) {

                        //insert items
                        let itemsData = res.data.items.data
                        if (itemsData) {
                            state.items = state.items.concat(itemsData)
                        }
                    }
                }
            })
    }

}