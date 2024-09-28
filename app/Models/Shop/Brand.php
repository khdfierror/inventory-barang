<?php

namespace App\Models\Shop;

use App\Concerns\HasUlids;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model implements FilamentUser
{
    use SoftDeletes, HasUlids;
    use HasFactory;

    protected $table = 'shop_brands';

    protected $fillable = [
        'name',
        'slug',
        'website',
        'visible',
        'description',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shop_brand_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
