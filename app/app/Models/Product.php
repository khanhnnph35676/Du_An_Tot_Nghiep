<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products';
    public $fillable = [
        'name',
        'image',
        'qty',
        'price',
        'description',
        'category_id',
        'view',
        'type'
    ];
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
        }
    public function galleries(){
        return $this->hasMany(Gallerie::class,'id','product_id');
    }
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }
    public function productOrders()
    {
        return $this->hasMany(ProductOder::class);
    }
}
