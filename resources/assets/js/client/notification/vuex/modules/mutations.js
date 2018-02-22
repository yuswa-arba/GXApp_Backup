/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../helpers/api'
import {api_path} from '../../../helpers/const'
import {showNotificationBar, notifType, showNotificationBubble, hideNotificationBubble} from'../../utils/util'

import series from 'async/series';
export default{

    listenToPersonalNotification(){
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

                            })
                    }

                }
            }).catch((err) => {
        })

    },
    getNotificationList(state, payload){
        get(api_path + 'profile/notification/list')
            .then((res) => {

                console.log(JSON.stringify(res.data))

                if (!res.data.isFailed) {
                    if (res.data.notifications) {
                        state.notificationList = res.data.notifications
                    }
                }
            })
    }
}