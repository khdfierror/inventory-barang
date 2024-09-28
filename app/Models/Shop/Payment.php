<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasUlids;
    use HasFactory;


    protected $table = 'purchase_payments';

    protected $guarded = [];

    public function orders(): BelongsTo 
    {
        return $this->belongsTo(Order::class);
    }

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}
