<?php

namespace Webkul\BagistoConnector\Hooks\Receivers;

use Illuminate\Support\Facades\Log;
use Webkul\Product\Repositories\ProductRepository;

class ProductReceiver
{
    /**
     * Create account.
     *
     * @param  array  $payload
     * @return void
     */
    public static function create(array $payload)
    {
        $data = collect($payload)->only([
            'api_entity_type',
            'api_entity_source_type_id',
            'api_entity_id',
            'sku',
            'name',
            'description',
            'quantity',
            'price',
        ]);

        $productRepository = app(ProductRepository::class)->where('api_entity_id', $data['api_entity_id']);

        if($productRepository->first())
        {
            $productRepository->update([
                'sku'                       => $data['sku'],
                'price'                     => $data['price'],
                'name'                      => $data['name'],
                'description'               => $data['description'],
                'quantity'                  => $data['quantity'],
                'api_entity_source_type_id' => $data['api_entity_source_type_id'],
                'api_entity_id'             => $data['api_entity_id']
            ]);
        } else {
            app(ProductRepository::class)->create([
                'sku'                       => $data['sku'],
                'price'                     => $data['price'],
                'name'                      => $data['name'],
                'description'               => $data['description'],
                'quantity'                  => $data['quantity'],
                'api_entity_source_type_id' => $data['api_entity_source_type_id'],
                'api_entity_id'             => $data['api_entity_id']
            ]);
        }
    }

    /**
     * update product.
     *
     * @param  array  $payload
     * @return void
     */
    public static function updateProductQty(array $payload)
    {
        $data = collect($payload)->only([
            'api_entity_id',
            'quantity',
        ]);

        return app(ProductRepository::class)
                                    ->where('api_entity_id', $data['api_entity_id'])
                                    ->update(['quantity' => $data['quantity']]);
    }

    /**
     * Delete product.
     *
     * @param  array  $payload
     * @return void
     */
    public static function deleteProduct($payload)
    {
        $data = collect($payload)->only([
            'api_entity_id',
            'api_entity_source_type_id',
        ]);

        return app(ProductRepository::class)
                    ->where('api_entity_id', $data['api_entity_id'])
                    ->delete();
    }
}
