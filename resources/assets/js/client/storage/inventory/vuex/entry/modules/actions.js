/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}, payload){
        commit('getPurchaseOrderStatuses')
        commit('getBranchOffices')
    },
    attemptInsertItemToInventory({commit, state}, payload){
        if (payload.itemId) {

            state.selectedItemToInsert.itemId = payload.itemId
            state.selectedItemToInsert.quantity = payload.quantity
            state.selectedItemToInsert.requiresSerialNumber = payload.requiresSerialNumber

            state.selectedItemToInsert.itemId = payload.itemId

            state.selectedPurchaseOrderId = state.currentPurchaseOrder.id

            if (state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex] != null) {
                state.selectedItemToInsert.itemName = state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex].itemName
                state.selectedItemToInsert.itemCode = state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex].itemCode
                state.selectedItemToInsert.quantity = parseInt(state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex].amountPurchased) - parseInt(state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex].inventoryHistory)
                state.selectedItemToInsert.requiresSerialNumber = state.currentPurchaseOrder.purchaseOrderItems.data[payload.itemIndex].requiresSerialNumber
            }


            //show modal
            $('#modal-attempt-insert-to-inventory').modal('show')
        }
    },
    insertToInventory({commit,state},payload){

        if(payload.itemsToInsert.length>0){
            commit({
                type:'insertToInventory',
                purchaseOrderId:state.selectedPurchaseOrderId,
                branchOfficeId:state.selectedBranchOfficeId,
                itemsToInsert:payload.itemsToInsert
            })
        }

    }
}