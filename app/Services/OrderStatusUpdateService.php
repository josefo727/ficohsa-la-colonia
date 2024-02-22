<?php

namespace App\Services;

use App\Adapters\VtexAdapter;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class OrderStatusUpdateService
{
    /**
     * @return void
     */
    public function updateOrdersStatus(): void
    {
        $orders = Order::query()
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->get();

        $orders->each(fn($order) => $this->updateOrderStatus($order));
    }

    /**
     * @return void
     */
    public function updateOrderStatus(Order $order): void
    {
        $domainKey = 'VTEX_MASTER_DOMAIN';
        $storeDomain = GeneralSetting::getValue($domainKey);
        app('config')->set('vtex.store_domain', $storeDomain);
        $info = app(VtexAdapter::class)->getOrder($order->orderId);
        $success = $info['success'];
        if (!$success) return;
        try {
            $order = $info['order'];
            $order->status = $order['status'];
            $order->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
