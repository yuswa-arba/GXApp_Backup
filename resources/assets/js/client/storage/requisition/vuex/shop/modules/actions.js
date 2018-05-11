/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit,state},payload){

        commit('getTotalItemInCart')

    },
    attemptAddItemToCart({commit, state}, payload){

        if (payload.id) {

            //reset previous item
            state.itemToAdd = {
                id: '',
                itemCode: '',
                name: '',
                unitFormat: '',
                statusName: '',
                photo: '',
                isDeleted: ''
            }

            //get item detail
            commit({
                type: 'getItemDetail',
                id: payload.id
            })

            //show modal
            $('#modal-attempt-add-item-to-cart').modal('show')


        } else {
            //error notification
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'Undefined item ID',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }

    }

}