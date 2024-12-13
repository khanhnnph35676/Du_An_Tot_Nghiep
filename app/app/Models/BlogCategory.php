<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_categories';
    public $fillable =[
        'blog_categories_name',
    ];
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
