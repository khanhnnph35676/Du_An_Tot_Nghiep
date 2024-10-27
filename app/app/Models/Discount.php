<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'discounts';
    public $fillable = [
        'discount',
        'priority',
        'start_date',
        'end_date',
        'name'
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
