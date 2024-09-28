<?php

namespace App\Models\Blog;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Link extends Model 
{
    use HasFactory, HasUlids;
    use HasTranslations;

    protected $table = 'blog_links';

    protected $fillable = [
        'url',
        'title',
        'description',
        'color',
        'image',
    ];

    public $translatable = [
        'title',
        'description',
    ];  
}
