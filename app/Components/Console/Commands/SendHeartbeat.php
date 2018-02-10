<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Components\Console\Commands;



use App\Components\Events\HeartBeat;
use App\Salary\Jobs\CheckUnconfirmedAtStage1;
use App\Salary\Jobs\CheckUnconfirmedAtStage2;
use App\Salary\Jobs\CheckUnconfirmedAtValidStage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendHeartbeat extends Command
{
    protected $signature ='component:send-heartbeat';
    protected $description = 'Send a heartbeat to the internet connection tile';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('send heartbeat');

        event(new HeartBeat());
    }
}