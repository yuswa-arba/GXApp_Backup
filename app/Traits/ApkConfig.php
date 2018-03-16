<?php

namespace App\Traits;

class ApkConfig
{
    public static $APK_VERSION = [
        'LATEST_VERSION_CODE' => 1,
        'LATEST_VERSION_NAME' => 'v 1.0.0',
        'LATEST_VERSION_DESC' => 'First upload beta version',

        'PREVIOUS_VERSION_CODE' => 1,
        'PREVIOUS_VERSION_NAME' => 'v 1.0.0',
        'PREVIOUS_VERSION_DESC' => 'First upload beta version',

        'STABLE_VERSION_CODE' => 1,
        'STABLE_VERSION_NAME' => 'v 1.0.0',
        'STABLE_VERSION_DESC' => 'First upload beta version'
    ];

    public static $APK_NAME = [
        'LATEST'=>'gxapp-employee-latest.apk',
        'PREVIOUS'=>'gxapp-employee-previous.apk',
        'STABLE'=>'gxapp-employee-stable.apk',
    ];

    public static $APK_PATH= [
        'LATEST' => 'downloads/apk/latest/gxapp-employee-latest.apk',
        'PREVIOUS'=>'downloads/apk/previous/gxapp-employee-previous.apk',
        'STABLE'=>'downloads/apk/previous/gxapp-employee-stable.apk',
    ];

    public static $DOWNLOAD_TYPE = [
        'LATEST'=>'latest',
        'PREVIOUS'=>'previous',
        'STABLE'=>'stable'
    ];

    public static $IS_FORCE_UPDATE = [
      'FORCE'=>true
    ];
}