<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionResultController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $orderId): JsonResponse
    {
        $order = app(Order::class)->getOrderByOrderId($orderId);

        if (is_null($order)) {
            return response()->json(['error' => 'La orden no ha sido encontrada.'], Response::HTTP_NOT_FOUND);
        }

        if ($order->transaction()->exists()) {
            return response()->json(['error' => 'La transacción ya ha sido registrada para esta orden.'], Response::HTTP_CONFLICT);
        }

        app(Transaction::class)->registerTransaction($request, $order->id);

        return response()->json(['message' => 'Transaction registrada correctamente.'], Response::HTTP_CREATED);
    }
}
