@role('developer')
<li class="">
    <a  href="javascript:;"class="">
        <span class="title">Developer</span>
        <span class=" arrow"></span>
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
            <a href="">Queue Jobs</a>
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
