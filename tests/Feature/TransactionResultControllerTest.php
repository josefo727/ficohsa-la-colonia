<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransactionResultControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_return_not_found_if_order_does_not_exist(): void
    {
        $orderId = '0000000000-00';
        $response = $this->postJson(route('api.transaction-result', $orderId), []);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(['error' => 'La orden no ha sido encontrada.']);
    }

    /** @test */
    public function should_return_conflict_if_order_has_already_registered_transaction(): void
    {
        $order = Order::factory()->create();
        Transaction::factory()->create(['order_id' => $order->id]);

        $response = $this->postJson(route('api.transaction-result', $order->order_id), []);

        $response->assertStatus(Response::HTTP_CONFLICT)
            ->assertJson(['error' => 'La transacción ya ha sido registrada para esta orden.']);
    }

    /** @test */
    public function should_register_transaction(): void
    {
        $order = Order::factory()->create();

        $data = [
            'ref' => '00012101-AB-2021-01-13',
            'uuid' => 'q1AW67ODkz',
            'status' => 'paid',
            'description' => 'Pago de Orden #AB-2021-01-13',
            'note' => null,
            'category' => 'other',
            'currency' => 'HNL',
            'tax_amount' => 0,
            'amount' => 1,
            'items' => [
                [
                    'title' => 'Pago de Orden AB20210113',
                    'tax' => 0,
                    'price' => 1,
                    'qty' => 1,
                    'total' => 1
                ]
            ],
            'customer_name' => 'John Doe',
            'customer_email' => 'carlos@pixel.hn',
            'customer_phone' => '99999999',
            'client_ip' => null,
            'client_device' => 'mac',
            'order' => 'AB-2021-01-13',
            'payment_hash' => '3e04fad9a503607a3ebf77532b1af94a',
            'billing_address' => 'Ave Circunvalacion',
            'billing_state' => 'CR',
            'billing_city' => 'San Pedro Sula',
            'billing_country' => 'HN',
            'billing_zip' => '',
            'created_at' => '2021-01-13 11:01:14',
            'paid_at' => '2021-01-13 11:01:18',
            'transaction_id' => '6105591372046292904011',
            'card_account' => '4234 •••• •••• 1234',
            'card_brand' => 'visa',
            'card_type' => 'CREDIT',
            'company_name' => 'My Company',
            'company_slug' => 'my-company',
            'company_key' => '2212294583',
            'is_overdue' => false,
            'payment_url' => 'https://www.pixelpay.app/my_company/1dab5ed0/checkout',
            'attach_url' => null,
            'extra' => [
                'codigoCliente' => '4782164',
                'codigoNegocio' => 'ATGSH-6712'
            ]
        ];

        $response = $this->postJson(route('api.transaction-result', ['order_id' => $order->order_id]), $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transactions', [
            'status' => $data['status'],
            'approved' => $data['status'] === 'paid',
            'authorization_id' => $data['ref'],
            'message' => $data['description'],
            'transaction_id' => $data['transaction_id'],
            'payment_hash' => $data['payment_hash'],
            'request_id' => $data['uuid'],
            'paid_at' => $data['paid_at'],
            'order_id' => $order->id,
        ]);
    }

}
