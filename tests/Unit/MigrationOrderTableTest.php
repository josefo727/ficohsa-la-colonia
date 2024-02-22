<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationOrderTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_have_expected_columns_in_orders_table(): void
    {
        $this->assertTrue(Schema::hasTable('orders'));

        $this->assertTrue(Schema::hasColumn('orders', 'id'));
        $this->assertTrue(Schema::hasColumn('orders', 'order_id'));
        $this->assertTrue(Schema::hasColumn('orders', 'complete'));
        $this->assertTrue(Schema::hasColumn('orders', 'cancel'));
        $this->assertTrue(Schema::hasColumn('orders', 'currency'));
        $this->assertTrue(Schema::hasColumn('orders', 'amount'));
        $this->assertTrue(Schema::hasColumn('orders', 'email'));
        $this->assertTrue(Schema::hasColumn('orders', 'first_name'));
        $this->assertTrue(Schema::hasColumn('orders', 'last_name'));
        $this->assertTrue(Schema::hasColumn('orders', 'callback'));
        $this->assertTrue(Schema::hasColumn('orders', 'vtex_status'));
        $this->assertTrue(Schema::hasColumn('orders', 'status'));
        $this->assertTrue(Schema::hasColumn('orders', 'order_creation_at'));
        $this->assertTrue(Schema::hasColumn('orders', 'resolution_at'));
        $this->assertTrue(Schema::hasColumn('orders', 'created_at'));
        $this->assertTrue(Schema::hasColumn('orders', 'updated_at'));
    }
}
