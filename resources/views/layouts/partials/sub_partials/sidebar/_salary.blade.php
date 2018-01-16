@can('access salary')
    <li class="">
        <a href="javascript:;">
            <span class="title">Salary</span>
            <span class=" arrow"></span>
        </a>
        <span class="icon-thumbnail"><i data-feather="credit-card"></i></span>
        <ul class="sub-menu">
            <li class="">
                <a href="{{route('salary.report')}}">Report & Generate</a>
                <span class="icon-thumbnail">rg</span>
            </li>
            <li class="">
                <a href="#">Employee</a>
                <span class="icon-thumbnail">e</span>
            </li>
            <li class="">
                <a href="{{route('salary.setting')}}">Settings</a>
                <span class="icon-thumbnail">st</span>
            </li>
        </ul>
    </li>
@endcan