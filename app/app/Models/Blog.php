<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blogs';
    public $fillable = [
        'status',
        'blog_image',
        'list_image	',
        'title',
        'short_content',
        'author',
        'full_content',
        'published_at',
        'category_id',
    ];
    public function blog()
    {
        return $this->belongsTo(Blog_categories::class, 'category_id', 'id');
    }
}
