<?php

namespace App\Services;

use Josefo727\GeneralSettings\Models\GeneralSetting;

class PixelPayService
{
    /**
     * @param array $order
     * @return string
     */
    public function generatePaymentLink($order): string
    {
        $baseURL = GeneralSetting::getValue('PIXELPAY_URL_BASE');
        $queryParams = [
            '_key' => GeneralSetting::getValue('PIXELPAY_KEY_ID'),
            '_cancel' => $order['cancel'],
            '_complete' => $order['complete'],
            '_currency' => $order['currency'],
            '_amount' => $order['amount'],
            '_order_id' => $order['order_id'],
            '_email' => $order['email'],
            '_first_name' => $order['first_name'],
            '_last_name' => $order['last_name'],
            '_callback' => $order['callback'],
        ];
        $queryString = http_build_query($queryParams);
        $url = "{$baseURL}?{$queryString}";
        return urldecode($url);
    }
}

