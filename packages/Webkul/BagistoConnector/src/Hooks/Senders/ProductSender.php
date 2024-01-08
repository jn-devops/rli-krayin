<?php

namespace Webkul\BagistoConnector\Hooks\Senders;

use Illuminate\Support\Facades\Log;
use Spatie\WebhookServer\WebhookCall;

class ProductSender
{
    /**
     * Send message to store.
     *
     * @param  object  $message
     * @return void
     */
    public static function create($product)
    {
        $payload = [
            'api_entity_type'           => 'product.update',
            'api_entity_source_type_id' => 2,
            'id'                        => $product->id,
            'sku'                       => $product->sku,
            'name'                      => $product->name,
            'description'               => $product->description,
            'quantity'                  => $product->quantity,
            'price'                     => $product->price,
        ];
        
        WebhookCall::create()
                    ->url(webhook_server_url())
                    ->useSecret(webhook_server_secret())
                    ->payload($payload)
                    ->dispatch();
    }
}
