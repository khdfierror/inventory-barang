<?php

namespace App\Models\Blog;


use App\Models\Comment;
use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory;

    use SoftDeletes, HasTags;

    protected $table = 'blog_posts';

    protected $fillable = [
        'blog_author_id',
        'blog_category_id',
        'title',
        'slug',
        'content',
        'published_at',
        'image',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

        // public function published(): Attribute
        // {
        //     return Attribute::make(
        //         get: fn() => $this->published_at ? true : false,
        //     );
        // }
        
        // public function status(): Attribute
        // {
        //     return Attribute::make(
        //         get: fn() => $this->published_at ? 'Published' : "Draft",
        //     );
        // }

    public function author(): BelongsTo
    {
    return $this->belongsTo(Author::class, 'blog_author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    } 

}
