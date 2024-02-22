<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Jobs\PaymentNotificationJob;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction): void
    {
        PaymentNotificationJob::dispatch($transaction->order->order_id)->onQueue('default');
    }
}
