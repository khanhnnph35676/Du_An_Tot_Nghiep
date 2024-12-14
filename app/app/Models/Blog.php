<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $primaryKey = 'idBlog';
    protected $fillable = [
        'BlogContent',
        'Status',
        'BlogDesc',
        'BlogTitle',
        'BlogSlug',
        'BlogImage',
        'blog_category_id',
    ];
    public function blog_categories()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
    
}
