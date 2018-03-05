/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit,state},payload){

        //empty selected items
        state.selectedItemsIdToRequest=[]

        commit('getItemInsideCarts')
    },
    getDataOnRequisitionForm({commit,state},payload){
        commit('getDeliveryWarehouses')
        commit('getDivisions')
        commit('getItemBeingRequestedDetails')
    }
}