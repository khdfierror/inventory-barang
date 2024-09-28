<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUlids;
    use HasFactory;


    protected $table = 'purchase_orders';

    protected $fillable = [
        'purchase_customer_id',
        'number',
        'total_price',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'address',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'purchase_customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'purchase_order_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }


}
