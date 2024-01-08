<?php

namespace Webkul\BagistoConnector\Hooks;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class BagistoProfile implements WebhookProfile
{
    /**
     * Is profile valid.
     */
    public function shouldProcess(Request $request): bool
    {
        // @add-translation
        $validator = Validator::make($request->all(), [
            'api_entity_type' => 'required',
        ]);
        
        switch ($request->api_entity_type) {
            case 'product.create':
                $validator = Validator::make($request->all(), [
                    'api_entity_source_type_id' => 'required',
                    'api_entity_id'             => 'required',
                ]);

                $this->customValidationFailed($validator, $request);
                
                break;

            default:
                break;
        }

        return ! $validator->fails();
    }

    /**
     * Custom validation error message
     *
     * @param object $validator
     * @return json
     */
    private function customValidationFailed($validator, $request)
    {
        if ($validator->fails()) {
            $reason = $validator->errors()->first();
            $response = response()->json([
                'status'  => false,
                'retry'   => true,
                'message' => "Request validation failed! $reason",
            ], 400)
            ->header('Content-Type', 'json')->send();
            $response->getContent();
            exit;
        } else {
            $request->all();
        }
    }
}
