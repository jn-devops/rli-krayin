<?php

namespace Webkul\BagistoConnector\Providers;

use Webkul\BagistoConnector\Listeners\ProductListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'bagisto.catalog.product.update.after' => [
            [ProductListener::class, 'updateProductInBagisto'],
        ],
    ];
}
