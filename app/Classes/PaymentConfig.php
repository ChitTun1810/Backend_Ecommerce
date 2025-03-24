<?php

namespace App\Classes;

class PaymentConfig
{
    public string $baseUrl, $merchantId, $secretKey, $description, $frontendReturnUrl, $backendReturnUrl;
    public function __construct(string $currency)
    {
        $mode                    = config('ccpp.mode');
        $this->baseUrl           = config(sprintf('ccpp.%s.baseUrl', $mode));
        $this->merchantId        = config(sprintf('ccpp.%s.%s.merchant_id', $mode, $currency));
        $this->secretKey         = config(sprintf('ccpp.%s.%s.secret', $mode, $currency));
        $this->description       = config(sprintf('ccpp.%s.description', $mode));
        $this->frontendReturnUrl = config(sprintf('ccpp.%s.frontendReturnUrl', $mode));
        $this->backendReturnUrl  = config(sprintf('ccpp.%s.backendReturnUrl', $mode));
    }
}
