<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Salary\Traits;


use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalConst;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


trait SalaryUtils
{

    /*
     * Make sure when you change this, you have to change all the data in employeeSalary table.
     * if there is one unencrypted salary in the table it would throw an error, and vice versa. So if you
     * want to use encryption make sure all the data in the employeeSalary table is ENCRYPTED, if you dont want to
     * use encryption, make sure all the data in employeeSalary table is UNENCRYPTED
     */
    public static $useEncryption = false;


    public function getEmployeeBasicSalary($basicSalary)
    {
        if (SalaryUtils::$useEncryption) {
            if ($basicSalary) {
                try {
                    $decryptedSalary = Crypt::decryptString($basicSalary);
                    return $this->formatRupiahCurrency($decryptedSalary);
                } catch (DecryptException $e) {
                    //
                }


            } else {
                return '';
            }
        } else {
            if ($basicSalary) {
                return $this->formatRupiahCurrency($basicSalary);
//                return $basicSalary;
            } else {
                return '';
            }
        }
    }

    public function getEmployeeBasicSalaryNoFormat($basicSalary)
    {
        if (SalaryUtils::$useEncryption) {
            if ($basicSalary) {
                try {
                    $decryptedSalary = Crypt::decryptString($basicSalary);
                    return $decryptedSalary;
                } catch (DecryptException $e) {
                    //
                }


            } else {
                return '';
            }
        } else {
            if ($basicSalary) {
                return $basicSalary;
            } else {
                return '';
            }
        }
    }

    public function encryptSalary($basicSalary)
    {
        if (SalaryUtils::$useEncryption) {
            if ($basicSalary) {
                return Crypt::encryptString($basicSalary);
            } else {
                return '';
            }
        } else {
            if ($basicSalary) {
                return $basicSalary;
            } else {
                return '';
            }
        }

    }

    public function formatRupiahCurrency($value){
        if($value>0 && is_float($value) && $value!=null && $value!=""){
            return number_format($value, 2, ',', '.');
        } else {
            return $value;
        }


    }

}