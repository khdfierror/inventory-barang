<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Model implements HasMedia
{
    use SoftDeletes, HasUlids;

    use InteractsWithMedia;
    use HasFactory;


    protected $table = 'purchase_customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function customer(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'purchase_customer_id');
    }

}
