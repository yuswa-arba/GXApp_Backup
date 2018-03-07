/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../../helpers/api'
import {api_path} from '../../../../../helpers/const'
import series from 'async/series';
export default{
    getApprovalStatusList(state, payload){
        get(api_path + 'storage/approvalStatus/list')
            .then((res) => {
                if (!res.data.isFailed) {
                    state.approvalStatuses = res.data.approvalStatuses.data
                }
            })
    },
    getRequisitionApproval(state, payload){

        let sortApproval = ''
        if (payload.sortApproval) {
            sortApproval = payload.sortApproval
        }

        get(api_path + 'storage/admin/approval?sortApproval=' + sortApproval)
            .then((res) => {

                state.isSearchingRequisition = true

                if (!res.data.isFailed) {
                    if (res.data.requisitions.data) {

                        state.requisitions = []

                        //insert requisitions
                        let requisitionData = res.data.requisitions.data
                        if (requisitionData) {
                            state.requisitions = state.requisitions.concat(requisitionData)
                        }

                        //insert pagination
                        state.paginationMeta = res.data.requisitions.meta.pagination
                    }

                    state.isSearchingRequisition = false

                } else {
                    state.isSearchingRequisition = false
                }

            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })

    },
    searchRequisition(state, payload){

        let search = ''
        if (payload.searchText) {
            search = payload.searchText
        }

        get(api_path + 'storage/admin/approval/search?v=' + search)
            .then((res) => {

                    state.isSearchingRequisition = true

                    if (!res.data.isFailed) {
                        if (res.data.requisitions.data) {

                            state.requisitions = []

                            //insert requisitions
                            let requisitionData = res.data.requisitions.data
                            if (requisitionData) {
                                state.requisitions = state.requisitions.concat(requisitionData)
                            }

                            //insert pagination
                            state.paginationMeta = res.data.requisitions.meta.pagination
                        }

                        state.isSearchingRequisition = false

                    } else {
                        state.isSearchingRequisition = false
                    }
                }
            )
    },
    saveApprovalAfterEdit(state, payload){

        let requisition = state.requisitions[payload.index]
        let requisitionItems = requisition.requisitionItems.data

        //get only id and isApproved property in array to be send in request
        let requisitionItemsUpdated = _.map(requisitionItems, item => _.pick(item, 'id', 'isApproved'))

        post(api_path + 'storage/admin/approval/requisition/editAndApprove', {
            requisitionId: payload.requisitionId,
            requisitionItemsUpdated: requisitionItemsUpdated
        })
            .then((res) => {

                if (!res.data.isFailed) {

                    requisition.approvalNumber = requisition.requisitionNumber + 'A'
                    requisition.approvalId = 1 // approval id approve
                    requisition.approvalName = 'Approve'
                    requisition.editing = false

                     $('.page-container').pgNotification({ /* Show success response */
                          style: 'flip',
                          message: res.data.message,
                          position: 'top-right',
                          timeout: 3500,
                          type: 'info'
                      }).show();

                } else {

                    $('.page-container').pgNotification({ /* Show error response */
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();

                }

            })
            .catch((err) => { /* Show error response */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })


    },
    declineRequisition(state, payload){

        post(api_path + 'storage/admin/approval/requisition/decline', {requisitionId: payload.requisitionId})
            .then((res) => {

                if (!res.data.isFailed) {

                    // Update requisition array
                    let requisition = state.requisitions[payload.index]
                    requisition.approvalNumber = requisition.requisitionNumber + 'D'
                    requisition.approvalId = 2 // approval id declined
                    requisition.approvalName = 'Declined'

                    // Update requisition items array
                    let requisitionItems = requisition.requisitionItems.data
                    _.forEach(requisitionItems, function (value, key) {
                        requisitionItems[key].isApproved = 0
                    })

                    $('.page-container').pgNotification({ /* Show success response */
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                } else { /* Show error response */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })
            .catch((err) => { /* Show error response */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })

    },
    approveRequisition(state, payload){
        post(api_path + 'storage/admin/approval/requisition/approve', {requisitionId: payload.requisitionId})
            .then((res) => {

                if (!res.data.isFailed) {

                    // Update requisition array
                    let requisition = state.requisitions[payload.index]
                    requisition.approvalNumber = requisition.requisitionNumber + 'A'
                    requisition.approvalId = 1 // approval id approve
                    requisition.approvalName = 'Approve'

                    // Update requisition items array
                    let requisitionItems = requisition.requisitionItems.data
                    _.forEach(requisitionItems, function (value, key) {
                        requisitionItems[key].isApproved = 1
                    })

                    $('.page-container').pgNotification({ /* Show success response */
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                } else { /* Show error response */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })
            .catch((err) => { /* Show error response */
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    }

}