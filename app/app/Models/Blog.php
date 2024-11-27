<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    // use HasFactory;
    public $timestamp = false;
    public $fillable = [
        'BlogContent',
        'Status',
        'BlogDesc',
        'BlogTitle',
        'BlogSlug',
        'BlogImage',
        'created_at',
        'updated_at',
        'blog_category_id',
    ];
    protected $primaryKey = 'idBlog';
    protected $table = 'blog';
    public function blog_categories()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id','id');
    }
}
