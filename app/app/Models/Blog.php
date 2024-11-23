<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    // SoftDeletes
    use HasFactory;
    protected $table = 'blogs';
    public $fillable = [
        'status',
        'post_image',
        'list_image	',
        'title',
        'short_content',
        'author',
        'full_content',
        'published_at',
        'category_id',
    ];
}
