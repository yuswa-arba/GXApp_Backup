/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{
    getDataOnCreate({commit, state}, payload){
        commit('getNPWPInformation')
    },
    showRequisitionListModal({commit, state}, payload){

        commit('getRequisitionList')
        $('#modal-select-requisition').modal('show')

    },
    showSupplierListModal({commit, state}, payload){

        commit('getSupplierList')
        $('#modal-select-supplier').modal('show')

    },
    startAddingItems({commit, state}, payload){

        //validate and check pre form object

        series([
                function (cb) {
                    // check if with supplier
                    if (state.selectedSupplier.id != null) {

                        // Insert to preFormObject
                        state.preFormObject.supplierId = state.selectedSupplier.id

                        // Callback success
                        cb(null, '')

                    } else {
                        // Callback error
                        cb('Supplier not found', '')
                    }
                },
                function (cb) {

                    // check if with requisition
                    if (state.preFormObject.withRequisition) {
                        if (state.selectedRequisition.id != null) {

                            // Insert to preFormObject
                            state.preFormObject.requisitionId = state.selectedRequisition.id
                            state.preFormObject.approvalNumber = state.selectedRequisition.approvalNumber

                            // Callback success
                            cb(null, '')

                        } else {
                            // Callback error
                            cb('Requisition not found', '')
                        }
                    } else {

                        // Callback success
                        cb(null, '')
                    }
                }
            ],
            function (err, result) { // Callback

                if (err == null) { //Success

                    state.preFormIsFinishAndValid = true

                    console.log(JSON.stringify(state.preFormObject))

                } else {

                    /* Show error response */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })


    }

}