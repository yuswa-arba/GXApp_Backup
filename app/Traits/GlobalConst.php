<?php

namespace App\Traits;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 10:07 AM
 */
trait GlobalConst
{
    /*
     * In some cases where server is not running at port 80 , it is required to use the server Private IP address and Defined Port
     * to run function such as Guzzle HTTP request. Example can be found : app/Http/Controllers/BackendV1/API/Traits/IssueTokenTrait.php -> issueTokenWithResponse()
     * */
    public static $SERVER_ADDR = [
        'PRIVATE_DEV'=>'http://localhost',
        'PRIVATE_PROD'=>'http://172.16.79.138:8080',
    ];

    /*
     *
     * */
    public static $CONFIG = [
        'RUN_ON_PORT_80' => true /* Check if web server run on port 80 */
    ];
}
