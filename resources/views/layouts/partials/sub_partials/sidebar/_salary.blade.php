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
                <a href="{{route('salary.payroll')}}">Payroll</a>
                <span class="icon-thumbnail">pl</span>
            </li>
            <li class="">
                <a href="{{route('salary.queue')}}">Queue</a>
                <span class="icon-thumbnail">q</span>
            </li>
            <li class="">
                <a href="{{route('salary.employee')}}">Employee</a>
                <span class="icon-thumbnail">e</span>
            </li>
            <li class="">
                <a href="{{route('salary.setting')}}">Settings</a>
                <span class="icon-thumbnail">st</span>
            </li>
            <li class="">
                <a href="{{route('salary.help')}}">Help</a>
                <span class="icon-thumbnail"><i class="fa fa-info-circle"></i></span>
            </li>
        </ul>
    </li>
@endcan