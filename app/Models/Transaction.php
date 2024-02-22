<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'approved' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return void
     */
    public function registerTransaction(Request $request, int $orderId): void
    {
        $jsonString = json_encode($request->all());

        static::query()->create([
            'status' => $request['status'],
            'approved' => $request['status'] === 'paid',
            'authorization_id' => $request['ref'],
            'message' => $request['description'],
            'transaction_id' => $request['transaction_id'],
            'payment_hash' => $request['payment_hash'],
            'request_id' => $request['uuid'],
            'processed' => false,
            'paid_at' => $request['paid_at'],
            'request' => $jsonString,
            'order_id' => $orderId,
        ]);
    }
}
