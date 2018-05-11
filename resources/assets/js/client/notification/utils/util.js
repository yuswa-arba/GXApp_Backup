/**
 * Created by kevinpurwono on 22/2/18.
 */

export function showNotificationBar(message, timeoutms, type, withSound) {

    $('.page-container').pgNotification({
        style: 'flip',
        message: message,
        position: 'top-right',
        timeout: timeoutms, //miliseconds
        type: type
    }).show()

    if(withSound){
        let sound = new Audio('/sounds/definite.ogg')
        sound.play()
    }

    showNotificationBubble()
}

export function showNotificationBubble(){
    let notificationBtn = $('#notification-center')
    notificationBtn.find('.bubble').removeClass('hide')
    notificationBtn.find('.bubble').addClass('show')
}

export function hideNotificationBubble(){
    let notificationBtn = $('#notification-center')
    notificationBtn.find('.bubble').removeClass('show')
    notificationBtn.find('.bubble').addClass('hide')
}

export function isNotificationListOpen(){

    return $('#quickview-notification').hasClass('open');

}

export function openNotificationList(){
    $('#quickview-notification').addClass('open')


}

export function closeNotificationList(){
    $('#quickview-notification').removeClass('open')
}

export const notifType = {
    success: 'success',
    danger: 'danger',
    info: 'info',
    warning: 'warning'
}
