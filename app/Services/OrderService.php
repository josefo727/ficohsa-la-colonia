<?php

namespace App\Services;

use App\Adapters\VtexAdapter;
use App\Classes\Status;
use App\Models\Order;
use Carbon\Carbon;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class OrderService
{
    protected string $orderId;

    protected string $paymentSystemKey;

    protected string $currencyKey;

    protected string $urlRedirect;

    protected array $response = [
        'found' => false,
        'needs_to_process' => false,
        'message' => 'Orden no encontrada',
        'url' => null,
    ];

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
        $this->paymentSystemKey = config('vtex.order.payment_system_key');
        $this->currencyKey = config('vtex.order.currency_key');
        $this->urlRedirect = (new DomainUrlService())->generate(request())
            .'/checkout/orderPlaced?og='
            .$this->getOrderGroup($orderId);
    }

    public function getOrderGroup(string $orderId): ?string
    {
        return preg_replace('/-(\d+)/', '', $orderId);
    }

    public function getOrderInfo(): array
    {
        $info = app(VtexAdapter::class)->getOrder($this->orderId);

        if (! $info['success']) {
            return $this->response;
        }

        $order = $info['order'];

        if ($this->needsToBeProcessed($order)) {
            $newOrder = $this->buildNewOrder($order);

            $savedOrder = Order::query()
                ->firstOrCreate(
                    ['order_id' => $newOrder['order_id']],
                    $newOrder
                );

            $this->response['found'] = true;
            $this->response['needs_to_process'] = false;
            $this->response['message'] = 'En espera de respuesta de Pixelpay.';
            $this->response['url'] = app(PixelPayService::class)->generatePaymentLink($newOrder);

            if ($savedOrder->wasRecentlyCreated) {
                $this->response['needs_to_process'] = true;
                $this->response['message'] = 'Se necesita procesar pago.';
            }

            return $this->response;
        }

        $this->response['found'] = true;
        $this->response['needs_to_process'] = false;
        $this->response['message'] = 'No se necesita procesar pago.';

        return $this->response;
    }

    public function needsToBeProcessed(array $order): bool
    {
        $paymentSystem = (string) data_get($order, $this->paymentSystemKey);
        $vtexPaymentSystems = GeneralSetting::getValue('VTEX_PAYMENT_SYSTEM');

        return is_array($vtexPaymentSystems) && in_array($paymentSystem, $vtexPaymentSystems)
            && $order['status'] === Status::ACTIONABLE_VTEX_STATE;
    }

    /**
     * @param  array  $order
     * @return array<string,mixed>
     */
    public function buildNewOrder($order): array
    {
        $client = data_get($order, 'clientProfileData');
        $email = $this->getClientEmail($client['userProfileId']);

        return [
            'order_id' => $order['orderId'],
            'complete' => urlencode($this->urlRedirect.'&complete=true'),
            'cancel' => urlencode($this->urlRedirect.'&cancel=true'),
            'currency' => data_get($order, $this->currencyKey),
            'amount' => $order['value'] / 100,
            'email' => $email,
            'first_name' => $client['firstName'],
            'last_name' => $client['lastName'],
            'callback' => urlencode(config('app.url').'/api/transaction-result/'.$order['orderId']),
            'vtex_status' => $order['status'],
            'status' => Status::NEEDS_APPROVAL,
            'needs_approval' => true,
            'order_creation_at' => Carbon::parse($order['creationDate'])->format('Y-m-d H:m:i'),
        ];
    }

    /*
     * @param string $userProfileId
     * @return string
     */
    public function getClientEmail(string $userProfileId): string
    {
        $response = app(VtexAdapter::class)->getEmailGiveUserId($userProfileId);

        return $response['success']
            ? $response['email']
            : '';
    }
}
