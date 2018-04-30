<?php
namespace App\Fingerspot\Jobs;

use App\Fingerspot\Model\TbDevice;
use App\Fingerspot\Model\TbScanLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:37 PM
 */
class CollectFingerspotScanLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {

    }

    /**
     * repeat slot maker execution each year8
     */
    public function handle()
    {

        $devices = TbDevice::all();

        foreach ($devices as $device) {

            $sn = "sn=" . $devices->device_sn;
            $port = $device->server_port;
            $url = $device->server_IP . "/scanlog/new";

            $output = $this->sendRequest($port, $url, $sn);

            if ($output) {
                foreach (json_decode($output) as $data) {

                    $scanLog = new TbScanLog();

                    $scanLog->sn = $data->SN;
                    $scanLog->scan_date = $data->ScanDate;
                    $scanLog->pin = $data->PIN;
                    $scanLog->verifymode = $data->VerifyMode;
                    $scanLog->iomode = $data->IOMode;
                    $scanLog->workcode = $data->WorkCode;

                    $scanLog->save();
                }
            }
        }
    }


    private function sendRequest($port, $url, $sn)
    {
        $curl = curl_init();
        set_time_limit(0);
        curl_setopt_array($curl, array(
                CURLOPT_PORT => $port,
                CURLOPT_URL => "http://" . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $sn,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $response = ("Error #:" . $err);
        }

        return $response;
    }


}