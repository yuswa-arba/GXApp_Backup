@can('view attendance')
    <li class="">
        <a href="javascript:;">
            <span class="title">Attendance</span>
            <span class=" arrow"></span>
        </a>
        <span class="icon-thumbnail"><i data-feather="clock"></i></span>
        <ul class="sub-menu">
            <li class="">
                <a href="{{route('attendance.dashboard')}}">Dashboard</a>
                <span class="icon-thumbnail">db</span>
            </li>

            <li class="">
                <a href="{{route('attendance.timesheet')}}">Timesheets</a>
                <span class="icon-thumbnail">ts</span>
            </li>
            <li class="">
                <a href="{{route('attendance.schedule')}}">Schedule</a>
                <span class="icon-thumbnail">sc</span>
            </li>
            <li class="">
                <a href="{{route('attendance.leave')}}">Leave</a>
                <span class="icon-thumbnail">lv</span>
            </li>
            @role('attendance operator')
            <li class="">
                <a href="{{route('attendance.slot')}}">Slots</a>
                <span class="icon-thumbnail">sl</span>
            </li>
            <li class="">
                <a href="{{route('attendance.setting')}}">Settings</a>
                <span class="icon-thumbnail">st</span>
            </li>
            @endrole
        </ul>
    </li>
@endcan