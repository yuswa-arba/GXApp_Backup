<script>
    $(document).ready(function () {

        $('body').css('zoom','90%')

        $('.page-container').pgNotification({
            style: 'flip-right',
            message: 'This page contains alot of interface, it is recommended to zoom out your browser to 90% or 80% for best experience (Chrome user should be automatically set to 90% already)',
            position: 'bottom-right',
            timeout: 10000,
            type: 'success'
        }).show();
    })
</script>