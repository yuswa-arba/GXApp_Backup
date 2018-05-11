<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Manager\Logics\EditTimesheet;


use App\Manager\Models\EditTimesheet;

abstract class SummaryEditTimesheetUseCase
{
    public static function getData(EditTimesheet $editTimesheet)
    {

        return (new static)->handle($editTimesheet);

    }

    abstract public function handle($editTimesheet);

}