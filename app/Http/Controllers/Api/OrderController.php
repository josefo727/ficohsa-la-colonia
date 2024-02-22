<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $orderInfo = (new OrderService(request()->order_id))->getOrderInfo();

        return response()->json($orderInfo, 200);
    }
}
