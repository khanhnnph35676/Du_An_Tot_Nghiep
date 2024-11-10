<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'product_variants';
    public $fillable =[
        'product_id',
        'price',
        'sku',
        'stock',
        'option_value',
        'image'
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function options()
    {
        return $this->belongsTo(VariantOption::class,'option_value','id');
    }
}
