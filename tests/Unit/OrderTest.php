<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_an_order_have_a_transaction(): void
    {
        $order = new Order();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasOne', $order->transaction());
    }

    /** @test */
    public function should_return_null_when_order_not_exists(): void
    {
        $order = Order::factory()->create();
        $orderId = 'non-existing-order-id';

        $result = $order->getOrderByOrderId($orderId);

        $this->assertNull($result);
    }

    /** @test */
    public function should_get_order_by_order_id(): void
    {
        $order = Order::factory()->create();

        $foundOrder = $order->getOrderByOrderId($order->order_id);

        $this->assertEquals($order->order_id, $foundOrder->order_id);
    }

}
