<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Attendance\Console\Commands;

use App\Fingerspot\Jobs\CollectFingerspotScanLog;
use Illuminate\Console\Command;

class FingerspotCollector extends Command
{
    protected $signature ='fingerspot:collector';
    protected $description = 'Collect data from fingerspot machine';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //php artisan queue:work --queue=repeater
        CollectFingerspotScanLog::dispatch()->onConnection('database')->onQueue('fingerspot');
    }
}