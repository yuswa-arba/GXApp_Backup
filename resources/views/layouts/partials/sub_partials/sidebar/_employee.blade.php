@can('view employee')
    @if(request()->route()->getPrefix()=='/employee')
        <li class="open active">
    @else
        <li class="">
            @endif
        <a href="javascript:;">
            <span class="title">Employee</span>
            @if(request()->route()->getPrefix()=='/employee')
                <span class="arrow open active"></span>
            @else
                <span class="arrow"></span>
            @endif
        </a>
        <span class="icon-thumbnail"><i data-feather="users"></i></span>
        <ul class="sub-menu">
            <li class="">
                <a href="{{route('employee.list')}}">List</a>
                <span class="icon-thumbnail">l</span>
            </li>
            <li class="">
                <a href="{{route('employee.recruitment')}}">Recruitment</a>
                <span class="icon-thumbnail">r</span>
            </li>
            <li class="">
                <a href="{{route('employee.resignation')}}">Resignation</a>
                <span class="icon-thumbnail">rg</span>
            </li>
        </ul>
    </li>
@endcan