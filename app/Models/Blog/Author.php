<?php

namespace App\Models\Blog;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'blog_authors';

    protected $fillable = [
        'name',
        'email',
        'photo',
        'bio',
        'instagram_handle',
        'twitter_handle',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'blog_author_id');
    }
}
