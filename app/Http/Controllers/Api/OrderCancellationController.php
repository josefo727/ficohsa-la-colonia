<?php

namespace App\Http\Controllers\Api;

use App\Classes\Status;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderCancellationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderCancellationController extends Controller
{
    public const MESSAGE_KEY = 'message';

    private $orderCancellationService;

    /**
     * Set the OrderCancellationService instance.
     */
    public function setOrderCancellationService(OrderCancellationService $service): void
    {
        $this->orderCancellationService = $service;
    }

    public function __invoke(): JsonResponse
    {
        $order = Order::query()
            ->whereDoesntHave('transaction')
            ->where('status', Status::NEEDS_APPROVAL)
            ->where('order_id', '=', request()->order_id)
            ->first();

        if (is_null($order)) {
            return response()->json([self::MESSAGE_KEY => 'La orden no ha sido encontrada.'], Response::HTTP_NOT_FOUND);
        }

        $result = app(OrderCancellationService::class)->cancelOrder($order);

        if ($result) {
            return response()->json([self::MESSAGE_KEY => 'La orden ha sido cancelada exitosamente.'], Response::HTTP_ACCEPTED);
        }

        return response()->json([self::MESSAGE_KEY => 'La orden no pudo ser cancelada.'], Response::HTTP_ACCEPTED);
    }
}
