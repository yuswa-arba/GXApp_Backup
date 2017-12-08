<script>
    $(document).ready(function () {

        $('body').css('zoom','90%')

        $('.page-container').pgNotification({
            style: 'bar',
            message: 'This page contains alot of interface, it is recommended to zoom out your browser to 90% for best experience (Chrome user should be automatically set to 90% already)',
            position: 'bottom',
            timeout: 0,
            type: 'success'
        }).show();
    })
</script>