@role('developer')
    @if(request()->route()->getPrefix()=='/developer')
    <li class="open active">
    @else
    <li class="">
        @endif
    <a  href="javascript:;"class="">
        <span class="title">Developer</span>
        @if(request()->route()->getPrefix()=='/developer')
            <span class="arrow open active"></span>
        @else
            <span class="arrow"></span>
        @endif
    </a>
    <span class="icon-thumbnail "><i data-feather="cpu"></i></span>
    <ul class="sub-menu">
        <li class="">
            <a href="">Dashboard</a>
            <span class="icon-thumbnail">db</span>
        </li>
        <li class="">
            <a href="{{route('developer.face')}}">Face API</a>
            <span class="icon-thumbnail">fa</span>
        </li>
        <li class="">
            <a href="{{route('developer.logs')}}">Logs</a>
            <span class="icon-thumbnail">l</span>
        </li>
        <li class="">
            <a href="{{route('developer.backup')}}">Backup</a>
            <span class="icon-thumbnail">b</span>
        </li>
        <li class="">
            <a href="{{route('developer.queueJob')}}">Queue Jobs</a>
            <span class="icon-thumbnail">qj</span>
        </li>
        <li class="">
            <a href="">Actions</a>
            <span class="icon-thumbnail">a</span>
        </li>
        <li class="">
            <a href="">Reports</a>
            <span class="icon-thumbnail">r</span>
        </li>
        <li class="">
            <a href="{{route('developer.test')}}">Test</a>
            <span class="icon-thumbnail">t</span>
        </li>
    </ul>
</li>
@endrole
