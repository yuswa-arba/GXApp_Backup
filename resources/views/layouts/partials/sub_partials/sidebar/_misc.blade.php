@can('access misc options')
    @if(request()->route()->getPrefix()=='/misc')
        <li class="open active">
    @else
        <li class="">
    @endif
    <a  href="javascript:;"class="">
        <span class="title">Misc</span>
        @if(request()->route()->getPrefix()=='/misc')
            <span class="arrow open active"></span>
        @else
            <span class="arrow"></span>
        @endif
    </a>
    <span class="icon-thumbnail "><i data-feather="triangle"></i></span>
    <ul class="sub-menu">
        <li class="">
            <a href="{{route('misc.index')}}">Index</a>
            <span class="icon-thumbnail">i</span>
        </li>
        <li class="">
            <a href="{{route('misc.notification')}}">Notification</a>
            <span class="icon-thumbnail">nf</span>
        </li>
        <li>
            <a href="{{url('https://dashboard.hypertrack.com/widget/map/users?key=sk_01c8366148340d8fa53fb0d61ddfc9097ecb6f41')}}"
            target="_blank">
                Hypertrack Users
            </a>
            <span class="icon-thumbnail">hu</span>
        </li>
        <li>
            <a href="{{url('https://dashboard.hypertrack.com/widget/map/actions?key=sk_01c8366148340d8fa53fb0d61ddfc9097ecb6f41')}}"
               target="_blank">
                Hypertrack Actions
            </a>
            <span class="icon-thumbnail">ha</span>
        </li>

    </ul>
</li>
@endrole
