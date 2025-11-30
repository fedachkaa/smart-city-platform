<?php

namespace App\Providers;

use App\Listeners\SendRegistrationUserEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendRegistrationUserEmail::class,
        ],
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
