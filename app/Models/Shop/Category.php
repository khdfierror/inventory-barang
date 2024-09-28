<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

class Category extends Model
{
    use SoftDeletes, HasUlids;
    use HasFactory;


    protected $table = 'shop_categories';

    protected $fillable = [
        'name',
        'slug',
        'visible',
        'description',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_category_product', 'category_id', 'product_id');
    }
}
