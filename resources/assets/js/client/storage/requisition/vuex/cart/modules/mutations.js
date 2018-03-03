/**
 * Created by kevinpurwono on 8/12/17.
 */

import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getItemInsideCarts(state, payload){

        get(api_path + 'storage/requisition/shop/cart/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.itemInsideCart.data) {
                        state.itemInsideCart = res.data.itemInsideCart.data
                    }
                }
            })
    },
    updateItemAmountInCart(state, payload){
        if (payload.itemCartId) {
                post(api_path + 'storage/requisition/shop/cart/updateItemAmountInCart', {
                        itemCartId: payload.itemCartId,
                        amount: payload.amount
                    }
                )
                .then((res) => {
                })
                .catch((err) => {
                })
        }

    }
}