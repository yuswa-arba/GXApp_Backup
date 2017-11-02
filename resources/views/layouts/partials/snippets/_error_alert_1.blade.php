@if ($errors->any())


    @if(count($errors) > 0)

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"></button>
                <strong>Error: </strong>{{$error}}
            </div>
        @endforeach

    @endif
@endif



<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="alert alert-{{ $msg }} alert-block">{{ Session::get('alert-' . $msg) }}
                <a href="#"
                   class="close"
                   data-dismiss="alert"
                   aria-label="close">&times;</a>
            </div>
            {{Session::forget('alert-' . $msg)}}
        @endif
    @endforeach
</div>