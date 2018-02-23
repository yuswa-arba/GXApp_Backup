/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../helpers/api'
import {api_path} from '../../../helpers/const'
import {showNotificationBar, notifType, showNotificationBubble, hideNotificationBubble} from'../../utils/util'

import series from 'async/series';
export default{

    listenToPersonalNotification(state, payload){

        get(api_path + 'profile/user/employee/id')
            .then((res) => {
                if (!res.data.isFailed) {
                    if (res.data.employeeId) {

                        let employeeId = res.data.employeeId

                        // Listen to echo
                        echo.private(`notify.${employeeId}`)
                            .listen('Account.Events.UserNotified', (data) => {

                                let message = data.message

                                showNotificationBar(message, 10000, notifType.success, true)

                                // get notification list
                                get(api_path + 'profile/notification/list')
                                    .then((res) => {

                                        if (!res.data.isFailed) {
                                            if (res.data.notifications) {
                                                state.notificationList = res.data.notifications
                                            }

                                            state.unreadExists = res.data.unreadExists

                                            showNotificationBubble()


                                        }
                                    })

                            })
                    }
                    a
                }
            }).catch((err) => {
        })

    },

    //TODO listen to assigned notificaiton recipients


    getNotificationList(state, payload){
        get(api_path + 'profile/notification/list')
            .then((res) => {

                if (!res.data.isFailed) {

                    if (res.data.notifications) {
                        state.notificationList = res.data.notifications
                    }

                    state.unreadExists = res.data.unreadExists

                    if (res.data.unreadExists) {
                        showNotificationBubble()
                    }
                }
            })
    },
    seenNotificationList(state, payload){
        get(api_path + 'profile/notification/seenAll')
            .then((res) => {
                if (!res.data.isFailed) {

                    hideNotificationBubble()

                    state.unreadExists = false
                }
            })
            .catch((err) => {
            })
    },
    seenNotification(state, payload){

        get(api_path + 'profile/notification/seen?notificationId=' + payload.notificationId)
            .then((res) => {
                if (!res.data.isFailed) {

                    // Update array has seen to true
                    state.notificationList[payload.indexList].notifData[payload.indexItem].hasSeen = 1


                }
            })
            .catch((err) => {
            })
    }
}