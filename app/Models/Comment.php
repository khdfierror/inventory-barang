<?php

namespace App\Models;

use App\Concerns\HasUlids;
use App\Models\Shop\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'comments';

    protected $guarded = [];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
