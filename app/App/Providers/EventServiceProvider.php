<?php namespace obsession\App\Providers;

use Illuminate\{
    Foundation\Support\Providers\EventServiceProvider as ServiceProvider,
    Support\Facades\Event
};
use obsession\App\Listeners\{
    AuthEventsListener,
    UsersEventsListener
};

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        AuthEventsListener::class,
        UsersEventsListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
