Dear @if($employee->gender=="Male") Mr @elseif($employee->maritalStatus==1 && $employee->gender=="Female")Mrs @elseif($employee->gender="Female") Ms @else @endif {{$employee->surname}}, we welcome you to the GlobalXtreme family.
Please proceed to verify your GX employee account by clicking on the link below:
....Link.....
Login details will be sent to you right after your account has been verified.
Best, GX Employee Team