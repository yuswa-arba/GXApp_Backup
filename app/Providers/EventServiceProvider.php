<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        /* Employment Event Listeners*/
        'App\Employee\Events\EmployeeCreated' => [
            'App\Employee\Listeners\SendEmployeeDataVerification'
        ],
        'App\Employee\Events\UserGenerated' => [
            'App\Employee\Listeners\SendLoginDetailsEmail',
        ],

        /* Email Event Listeners*/
        'Illuminate\Mail\Events\MessageSending' => [
            'App\Mail\Listeners\SendingMessageListener',
        ],
        'Illuminate\Mail\Events\MessageSent' => [
            'App\Mail\Listeners\SentMessageListener',
        ]


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
