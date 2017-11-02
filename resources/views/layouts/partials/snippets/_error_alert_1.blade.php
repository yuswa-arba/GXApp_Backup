@if ($errors->any())

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <button class="close" data-dismiss="alert"></button>
            <strong>Error: </strong>{{$error}}
        </div>
    @endforeach

@endif