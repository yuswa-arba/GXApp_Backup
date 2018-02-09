<?php

namespace App\Employee\Models;

use App\Account\Models\User;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Components\Models\Bank;
use App\Components\Models\DivisionManager;
use App\Components\Models\EducationLevel;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
use App\Fingerspot\Model\TbScanLog;
use App\Fingerspot\Model\TbUser;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\EmployeeSalary;
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FingerspotUser extends Model
{
    use Notifiable;

    protected $table = 'fingerspotUserEmployee';

    protected $guarded = [''];


    public function masterEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }


}
