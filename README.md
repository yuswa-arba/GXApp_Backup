# GXApp_Employee_Server


###How to use session flash alert notification
**Color, style, position** should be included in order for the notification to show.
It will as well be the key to get the message from the flash session.


**Example :**
```
$request->session()->flash('alert-danger-bar-top', 'You don\'t have permission to access this page');
```

**THIS WILL POP UP AT TOP WITH THE STYLE OF BAR AND COLOR OF DANGER**

source :
```
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @foreach(['bar','flip','simple','circle'] as $style)
        @foreach(['top','bottom','top-right','bottom-right'] as $position)
            @if(Session::has('alert-' . $msg .'-'.$style.'-'.$position))
                <script>
                    (function ($) {
                        var position = $('.tab-pane.active .position.active').attr('data-placement'); // Placement of the notification

                        $('.page-container').pgNotification({
                            style: "{{$style}}",
                            message: '{{ Session::get('alert-' . $msg .'-'.$style.'-'.$position) }}',
                            position: "{{$position}}",
                            timeout: 3500,
                            type: "{{$msg}}"
                        }).show();
                    })(window.jQuery);
                </script>
            @endif
        @endforeach
    @endforeach
@endforeach
```


**Routing**
- Backend for helpdesk are call via web route with custom middleware
- Backend for Android are call via api route with Passport Oauth token
- Client for helpdesk are call via web route with custom middleware