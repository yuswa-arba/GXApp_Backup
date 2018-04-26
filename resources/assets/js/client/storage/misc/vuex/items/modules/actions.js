/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{

    getDataOnCreate({commit,state},payload){
        commit('getItemCategories')
        commit('getItemTypes')
        commit('getItemUnits')
        commit('getItemStatuses')
    },
    attemptEditPrice({commit,state},payload){

        let item = state.items[payload.index]

        if(item!=null){
            //set selected item
            state.selectedItem.id = item.id
            state.selectedItem.itemIndex = payload.index
            state.selectedItem.itemName = item.name
            state.selectedItem.itemCode = item.itemCode
            state.selectedItem.sellingPrice = item.latestSellingPrice
            state.selectedItem.purchasedPrice = item.latestPurchasedPrice
            state.selectedItem.finePrice = item.finePrice

            //show modal
            $('#modal-edit-item-price').modal('show')
        }




    }

}