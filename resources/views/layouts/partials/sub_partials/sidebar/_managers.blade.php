@if(\Illuminate\Support\Facades\Auth::user()->employee!=null)
    @if(\Illuminate\Support\Facades\Auth::user()->employee->divisionManager!=null)
        @if(\Illuminate\Support\Facades\Auth::user()->employee->divisionManager->isActive==1)
            @if(request()->route()->getPrefix()=='/manager')
                <li class="open active">
            @else
                <li class="">
                    @endif
                    <a href="javascript:;">
                        <span class="title">Manager</span>
                        @if(request()->route()->getPrefix()=='/manager')
                            <span class="arrow open active"></span>
                        @else
                            <span class="arrow"></span>
                        @endif
                    </a>
                    <span class="icon-thumbnail"><i data-feather="user"></i></span>
                    <ul class="sub-menu">
                        <li class="">
                            <a href="{{route('manager.editTimesheet')}}">Edit Timesheet</a>
                            <span class="icon-thumbnail">et</span>
                        </li>

                    </ul>
                </li>
            @endif
        @endif
    @endif