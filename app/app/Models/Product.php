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
        return $this->hasMany(ProductOder::class, 'product_id');
    }
    public function soldQuantity()
    {
        return $this->productOrders()
            ->whereHas('order', function ($query) {
                $query->where('status', 4); // Chỉ tính đơn hàng có status = 4
            })
            ->selectRaw('SUM(quantity) as total_sold')
            ->groupBy('product_id');
    }
    public function totalSold()
    {
        return $this->productOrders()
            ->whereHas('order', function ($query) {
                $query->where('status', 4);
            })
            ->selectRaw('COALESCE(SUM(quantity), 0) as total_sold')
            ->groupBy('product_id');
    }
}
