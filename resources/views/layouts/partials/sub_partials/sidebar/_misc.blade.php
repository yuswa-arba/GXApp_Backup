@role('developer')
<li class="">
    <a  href="javascript:;"class="">
        <span class="title">Misc</span>
        <span class=" arrow"></span>
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

    </ul>
</li>
@endrole
