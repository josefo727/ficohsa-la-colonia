<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTransactionTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_have_expected_columns_in_transactions_table(): void
    {
        $this->assertTrue(Schema::hasTable('transactions'));

        $this->assertTrue(Schema::hasColumn('transactions', 'id'));
        $this->assertTrue(Schema::hasColumn('transactions', 'status'));
        $this->assertTrue(Schema::hasColumn('transactions', 'approved'));
        $this->assertTrue(Schema::hasColumn('transactions', 'authorization_id'));
        $this->assertTrue(Schema::hasColumn('transactions', 'message'));
        $this->assertTrue(Schema::hasColumn('transactions', 'transaction_id'));
        $this->assertTrue(Schema::hasColumn('transactions', 'payment_hash'));
        $this->assertTrue(Schema::hasColumn('transactions', 'request_id'));
        $this->assertTrue(Schema::hasColumn('transactions', 'processed'));
        $this->assertTrue(Schema::hasColumn('transactions', 'paid_at'));
        $this->assertTrue(Schema::hasColumn('transactions', 'request'));
        $this->assertTrue(Schema::hasColumn('transactions', 'order_id'));
        $this->assertTrue(Schema::hasColumn('transactions', 'created_at'));
        $this->assertTrue(Schema::hasColumn('transactions', 'updated_at'));
    }
}
