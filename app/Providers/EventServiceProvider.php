<?php

namespace App\Providers;

use App\Models\Dtr;
use App\Models\Token;
use App\Observers\DtrObserver;
use App\Observers\TokenObserver;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Token::observe(TokenObserver::class);
        Dtr::observe(DtrObserver::class);

    }
}
