<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\EmployeeSalary;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Traits\SalaryUtils;
use Illuminate\Support\Facades\Crypt;
use League\Fractal\TransformerAbstract;

class EmployeeSalaryTransformer extends TransformerAbstract
{

    use SalaryUtils;

    public function transform(EmployeeSalary $employeeSalary)
    {

        $defaultBasicSalary = PayrollSetting::where('name','default-salary')->first()->value;

        return [
            'id' => $employeeSalary->id,
            'employeeId'=>$employeeSalary->employeeId,
            'basicSalary'=>$this->getEmployeeBasicSalary($employeeSalary->basicSalary?$employeeSalary->basicSalary:$defaultBasicSalary),
            'basicSalaryNoFormat'=>$this->getEmployeeBasicSalaryNoFormat($employeeSalary->basicSalary?$employeeSalary->basicSalary:$defaultBasicSalary),
            'insertedDate'=>$employeeSalary->insertedDate,
            'insertedBy'=>$employeeSalary->insertedBy,
        ];
    }


}
