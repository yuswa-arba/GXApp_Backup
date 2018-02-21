let orderId = 1

echo.private(`orderRequested.${orderId}`)
    .listen('Storage.Events.OrderRequested', (data) => {

        console.log('orderRequested', data)

        $('.page-container').pgNotification({
            style: 'flip',
            message: 'You have 1 new notification',
            position: 'top-right',
            timeout: 2500,
            type: 'success'
        }).show()

    })