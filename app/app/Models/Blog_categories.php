<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog_categories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blog_categories';
    public $fillable = [
        'blog_categories_name',
    ];
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function blogList()
    {
        return $this->blogs()->get();
    }
}
