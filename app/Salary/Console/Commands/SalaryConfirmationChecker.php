<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Salary\Console\Commands;



use App\Salary\Jobs\CheckUnconfirmedAtStage1;
use App\Salary\Jobs\CheckUnconfirmedAtStage2;
use App\Salary\Jobs\CheckUnconfirmedAtValidStage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SalaryConfirmationChecker extends Command
{
    protected $signature ='salary:check-confirmation';
    protected $description = 'Check Salary confirmation';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //php artisan queue:work --queue=checker
        CheckUnconfirmedAtValidStage::dispatch()->onConnection('database')->onQueue('checker');
        CheckUnconfirmedAtStage1::dispatch()->onConnection('database')->onQueue('checker');
        CheckUnconfirmedAtStage2::dispatch()->onConnection('database')->onQueue('checker');
    }
}