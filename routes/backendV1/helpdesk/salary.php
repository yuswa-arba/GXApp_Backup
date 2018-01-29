<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 4:50 PM
 */


/*
 |--------------------------------------------------------------------------
 | Salary Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

Route::prefix('v1/h')->group(function () {
//    Route::prefix('salary')->namespace('BackendV1\Helpdesk\Salary')->middleware('auth.admin')->group(function () {
    Route::prefix('salary')->namespace('BackendV1\Helpdesk\Salary')->group(function () {

        Route::get('bonuscut/list', 'BonusCutController@list');
        Route::post('bonuscut/create', 'BonusCutController@create');
        Route::post('bonuscut/edit', 'BonusCutController@edit');
        Route::post('bonuscut/delete', 'BonusCutController@delete');

        Route::get('generalBC/bonuscut/list', 'GeneralBonusCutController@bonusCutList');
        Route::get('generalBC/list', 'GeneralBonusCutController@list');
        Route::post('generalBC/create', 'GeneralBonusCutController@create');
        Route::post('generalBC/edit', 'GeneralBonusCutController@edit');

        Route::get('employee/detail/{employeeId}', 'EmployeeController@detail');
        Route::get('employee/availableBC/list/{employeeId}', 'EmployeeController@availableBonusCutList');
        Route::post('employee/save/basicSalary/{employeeId}', 'EmployeeController@saveSalary');
        Route::post('employee/use/bonusCut/{employeeId}', 'EmployeeController@useBonusCut');
        Route::post('employee/save/bonusCut/{employeeId}', 'EmployeeController@saveBonusCut');
        Route::post('employee/remove/bonusCut/{employeeId}', 'EmployeeController@removeBonusCut');
        Route::get('employee/history/{employeeId}','EmployeeController@getSalaryReportHistory');

        Route::get('report/generate/attempt', 'SalaryReportController@attemptGenerate');
        Route::post('report/generate', 'SalaryReportController@generate');
        Route::get('report/generate/logs', 'SalaryReportController@getLogs');
        Route::get('report/generate/logs/detail/{id}', 'SalaryReportController@getLogDetails');

        Route::get('payrollSetting/list','PayrollSettingController@list');
        Route::post('payrollSetting/edit','PayrollSettingController@edit');
        Route::get('payrollSetting/defaultGenerateDate','PayrollSettingController@getDefaultGenerateDate');

        Route::get('payroll/generateSalary/history','PayrollController@getGenerateSalaryHistory');
        Route::get('payroll/report/details/{salaryReportLogID}','PayrollController@details');
        Route::post('payroll/report/refresh/{salaryReportLogID}','PayrollController@refresh');
        Route::get('payroll/list','PayrollController@list');
        Route::get('payroll/lastPayroll/{salaryReportLogID}','PayrollController@getLastPayrollDetail');
        Route::get('payroll/lastGeneratedPayroll','PayrollController@getLastGeneratedPayroll');
        Route::get('payroll/generate/attempt','PayrollController@attemptGenerate');
        Route::post('payroll/generate','PayrollController@generate');
        Route::get('payroll/download/file/{generatedPayrollId}','PayrollController@downloadFile');
        Route::post('payroll/delete/file/{generatedPayrollId}','PayrollController@deleteFile');

        Route::get('queue/list','SalaryQueueController@list');

    });
});