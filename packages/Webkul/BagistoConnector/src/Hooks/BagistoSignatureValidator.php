<?php

namespace Webkul\BagistoConnector\Hooks;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class BagistoSignatureValidator implements SignatureValidator
{
    /**
     * Is signature valid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\WebhookClient\WebhookConfig  $config
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signatureHeaderName = $config->signatureHeaderName;
       
        $signature = $request->header($signatureHeaderName);
        
        if (! $signature) {
            return false;
        }

        $signingSecret = $config->signingSecret;
      
        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }
        
        $computedSignature = hash_hmac('sha256', $request->getContent(), $signingSecret);

        return hash_equals($signature, $computedSignature);
    }
}
