let groupTypeIds = [1, 2, 8, 7] //test only

let notifType = {
    success: 'success',
    danger: 'danger',
    info: 'info',
    warning: 'warning'
}

let requisitionStorageId = 2
let trackingOrderStorageId = 3

let sounds = new Audio('/sounds/definite.ogg')

for (let i = 0; i < groupTypeIds.length; i++) {

    switch (i) {
        case 1:
            break;
        case requisitionStorageId: //listen to requisition stoarge
            echo.private(`storage.${requisitionStorageId}`)
                .listen('Storage.Events.OrderRequested', (data) => {

                    console.log('orderRequested', data)

                    let message = 'New storage order has been requested'

                    showNotificationBar(message, 10000, notifType.success)
                    playNotifySound(2, 0)


                })
            break;
        case trackingOrderStorageId: //listen to tracking order storage
            break;
        default:
            break;
    }

}


function playNotifySound(times, current) {

    if (current < times) {
        sounds.play()
        current++ //increment
        playNotifySound(times, current)
    }

}

function showNotificationBar(message, timeoutms, type) {

    $('.page-container').pgNotification({
        style: 'flip',
        message: message,
        position: 'top-right',
        timeout: timeoutms, //miliseconds
        type: type
    }).show()

}