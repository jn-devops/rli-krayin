<?php

namespace Webkul\BagistoConnector\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\BagistoConnector\Hooks\Senders\ProductSender;

class ProductListener
{
    /**
     * update product in bagisto.
     *
     * @param  object  $product
     * @return void
     */
    public function updateProductInBagisto($product)
    {
        Log::info($product);
        ProductSender::create($product);
    }
}
