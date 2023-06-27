<?php

namespace App\Providers;

use Ddd\Domain\Events\EventCollector;
use Infrastructure\Events\EventDispatcher;
//use Ddd\Infrastructure\Events\EventDispatcher;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        /**
         * Bind the Infrastructure Event dispatcher to the Domain Interface
         */
        $this->app->instance(
            'Ddd\Domain\Events\EventDispatcher', new EventDispatcher(
                app('events'), EventCollector::instance()
            )
        );
    }
}
