<?php

namespace App\Classes;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use App\Classes\PaymentConfig;

class CCPP
{
    public PaymentConfig $config;

    public $order;

    public string $currencyCode;

    public function __construct($order, ?string $currencyCode = null)
    {
        $this->order      = $order;
        $this->currencyCode = $currencyCode ?? config('constants.currency.MMK');
        $this->config       = new PaymentConfig($this->currencyCode);
    }

    /**
     * get payment Token
     */
    public function getPaymentToken($invoiceNo) : object
    {
        $payload = [
            'merchantId'        => $this->config->merchantId,
            'invoiceNo'         => $invoiceNo,
            'description'       => $this->config->description,
            'amount'            => $this->order->grand_total,
            'currencyCode'      => $this->currencyCode,
            'paymentChannel'    => ['ALL'],
            'frontendReturnUrl' => $this->config->frontendReturnUrl,
            'backendReturnUrl'  => $this->config->backendReturnUrl,
        ];

        $jwt     = JWT::encode($payload, $this->config->secretKey, 'HS256');
        $payload = ['payload' => $jwt];
        $payload = json_encode($payload);

        $client   = new Client();
        $response = $client->request('POST', $this->config->baseUrl . '/paymentToken', [
            'headers' => [
                'Accept'       => 'text/plain',
                'Content-Type' => 'application/*+json',
            ],
            'body'    => $payload,
        ]);
        $res      = json_decode($response->getBody());
        return JWT::decode($res->payload, new Key($this->config->secretKey, 'HS256'));
    }

    /**
     * payment inquire
     *
     * @param [type] $paymentToken
     * @param [type] $invoiceNumber
     */
    public function paymentInquiry($paymentToken, $invoiceNumber)
    {
        $payload = [
            'payload'    => $paymentToken,
            'merchantID' => $this->config->merchantId,
            'invoiceNo'  => $invoiceNumber,
        ];

        $jwt     = JWT::encode($payload, $this->config->secretKey, 'HS256');
        $payload = ['payload' => $jwt];
        $payload = json_encode($payload);

        $client   = new Client();
        $response = $client->request('POST', $this->config->baseUrl . '/paymentInquiry', [
            'headers' => [
                'Accept'       => 'text/plain',
                'Content-Type' => 'application/*+json',
            ],
            'body'    => $payload,
        ]);

        $res = json_decode($response->getBody());
        return JWT::decode($res->payload, new Key($this->config->secretKey, 'HS256'));
    }
}

