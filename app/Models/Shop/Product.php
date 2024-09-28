<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Interaction;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasUlids;

    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'shop_products';

    protected $fillable = [
        'shop_brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'qty',
        'security_stock',
        'old_price',
        'price',
        'cost',
        'published_at',
        'backorder',
        'requires_shipping',
    ];

    protected $casts = [
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'datetime',
        
    ];

    public function published(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->published_at ? true : false,
        );
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->published_at ? 'Published' : 'Draft',
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'shop_brand_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'product_id', 'category_id')->withTimestamps();
    }


}
