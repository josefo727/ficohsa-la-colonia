<?php

namespace App\Services;

use App\Adapters\VtexAdapter;
use App\Classes\Status;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderCancellationService
{
    /**
     * @return void
     */
    public function cancelUnpaidOrders(): void
    {
        $orders = Order::query()
            ->whereDoesntHave('transaction')
            ->where('status', Status::NEEDS_APPROVAL)
            ->where('created_at', '<=', Carbon::now()->subHour())
            ->get();

        $orders->each(fn($order) => $this->cancelOrder($order));
    }

    /**
     * @return void
     */
    public function cancelOrder(Order $order): void
    {
        if ($order->status !== Status::NEEDS_APPROVAL || $order->transaction()->exists()) {
            return;
        }

        try {
            $response = app(VtexAdapter::class)->cancelOrder($order->order_id);
            $success = $response['success'];
            if ($response['success']) {
                $order->status = Status::CANCELLED;
                $order->save();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
