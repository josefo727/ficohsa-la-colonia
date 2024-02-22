<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_a_transaction_belong_to_an_order(): void
    {
        $transaction = new Transaction();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $transaction->order());
    }

    /** @test */
    public function should_register_transaction_creates_record_in_database(): void
    {
        // Arrange
        $order = Order::factory(Order::class)->create();
        $requestData = [
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
            'billing_zip' => null,
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

        $request = new Request($requestData);

        // Act
        (new Transaction)->registerTransaction($request, $order->id);

        // Assert
        $this->assertDatabaseHas('transactions', [
            'status' => 'paid',
            'approved' => true,
            'authorization_id' => '00012101-AB-2021-01-13',
            'message' => 'Pago de Orden #AB-2021-01-13',
            'transaction_id' => '6105591372046292904011',
            'processed' => false,
            'paid_at' => '2021-01-13 11:01:18',
            'order_id' => $order->id
        ]);
    }

}
