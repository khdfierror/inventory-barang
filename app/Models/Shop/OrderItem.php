<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasUlids;
    use HasFactory;


    protected $table = 'purchase_order_items';

    protected $fillable = [
        'shop_order_id',
        'shop_product_id',
        'qty',
        'unit_price',
    ];
}
