

@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <script>
            (function ($) {
                var position = $('.tab-pane.active .position.active').attr('data-placement'); // Placement of the notification

                $('.page-container').pgNotification({
                    style: 'bar',
                    message: '{{ Session::get('alert-' . $msg) }}',
                    position: 'top',
                    timeout: 3000,
                    type: "{{$msg}}"
                }).show();
            })(window.jQuery);
        </script>
    @endif
@endforeach