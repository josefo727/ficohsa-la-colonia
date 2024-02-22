<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $orders = Order::query()
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
