<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOder extends Model
{
    use HasFactory;
    protected $table = 'product_orders';
    public $fillable = [
        'order_id',
        'list_order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function product_variants()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}
