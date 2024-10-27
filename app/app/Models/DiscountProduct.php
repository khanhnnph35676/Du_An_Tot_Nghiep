<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    use HasFactory;
    protected $table = 'discounts_products';
    public $fillable = [
        'product_id',
        'name_discount',
    ];
}