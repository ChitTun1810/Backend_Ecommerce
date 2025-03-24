<?php

use Carbon\Carbon;

if (!function_exists('canLoadMore')) {
  function canLoadMore($query)
  {
    $request    = request();
    $totalPages = ceil($query->total() / ($request->limit ?? 10));
    return $query->total() == 0 || $request->page == $totalPages ? false : true;
  }
}


if (!function_exists('calculateTaxAndDiscount')) {
  function calculateTaxAndDiscount($type, $discount, $price)
  {
    if ($type == 'percent') {
      return $price * ($discount / 100);
    } else if ($type == 'fixed') {
      return $discount;
    }
  }
}

if (!function_exists('generateCode')) {
  function generateCode($model)
  {
    $today = Carbon::today();

    $numbers = $model::whereDate('created_at', $today)->count();

    $number = ($numbers % 999999) + 1;

    $formattedCounter = str_pad($number, 6, '0', STR_PAD_LEFT);

    return date('dmy') . $formattedCounter;
  }
}

if (!function_exists('ccpp_payments')) {
  function ccpp_payments()
  {
    return [
      'AL'             => 'ALIPAY',
      'AS'             => 'AliPay Scan QR (B scan C)',
      'AQ'             => 'AliPay Transaction QR (C scan B)',
      'AM'             => 'AMEX',
      'AP'             => 'ALTERNATIVE PAYMENT',
      'DI'             => 'DISCOVER',
      'DN'             => 'DINERS',
      'JC'             => 'JCB',
      'LP'             => 'LINEPAY',
      'MA'             => 'MASTERCARD',
      'MP'             => 'MPU',
      'RP'             => 'RUPAY',
      'UA'             => 'UATP',
      'UP'             => 'CHINA UNION PAY',
      'VI'             => 'VISA',
      'WC'             => 'WECHAT',
      'WQ'             => 'WeChat QR (C scan B)',
      'WS'             => 'WeChat Scan QR (B scan C)',
      'EQ'             => 'QR Gateway',
      'EVI'            => 'QR Gateway - VISA',
      'EMA'            => 'QR Gateway - MASTER',
      'ETQ'            => 'QR Gateway - Thai QR',
      'EPN'            => 'QR Gateway - PAYNOW',
      'BD'             => 'BILLDESK',
      'BO'             => 'BOOST',
      'CA'             => 'CCAVENUE',
      'CB'             => 'CBPay',
      'DA'             => 'DASH',
      'GC'             => 'GCASH',
      'GP'             => 'GRABPAY',
      'HM'             => 'HUMM',
      'KB'             => 'KBZPay',
      'KP'             => 'KCP',
      'MM'             => 'MOMO',
      'OC'             => 'OCBC PAYANYONE',
      'OK'             => 'OKDOLLAR',
      'OT'             => 'OCTOPUS',
      'PA'             => 'PAYPAL',
      'PM'             => 'PAYMAYA',
      'PN'             => 'PAYNOW',
      'SH'             => 'SHOPEEPAY',
      'SQ'             => 'SHOPEEPAY QR',
      'TG'             => 'TOUCH N GO',
      'TM'             => 'TRUEMONEY',
      'WA'             => 'WAVE',
      'ATM'            => '123 ATM Machine',
      'GPI'            => 'GrabPay Installments',
      'GPP'            => 'GrabPay Postpaid',
      'GPC'            => 'GrabPay Credit Card',
      'BANKCOUNTER'    => '123 Bank Counter',
      'KIOSK'          => '123 Kiosk Machines',
      'IBANKING'       => '123 Internet Banking',
      'MOBILEBANKING'  => '123 Mobile Banking',
      'OVERTHECOUNTER' => '123 Over the counter',
      'WEBPAY'         => '123 Web Payment',
    ];
  }
}
