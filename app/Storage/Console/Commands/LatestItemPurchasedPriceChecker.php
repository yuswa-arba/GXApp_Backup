<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Storage\Console\Commands;


use App\Attendance\Jobs\CheckAttendanceTimesheet;
use App\Storage\Jobs\UpdateLatestItemPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LatestItemPurchasedPriceChecker extends Command
{
    protected $signature = 'storage:latest-item-price';
    protected $description = 'Update latest item price based on purchased order';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        UpdateLatestItemPrice::dispatch()->onConnection('database')->onQueue('checker');
    }
}