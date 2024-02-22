<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * @return HasOne
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * @return self|null
     */
    public function getOrderByOrderId(string $orderId): self|null
    {
        return static::query()
            ->firstWhere('order_id', $orderId);
    }

}
