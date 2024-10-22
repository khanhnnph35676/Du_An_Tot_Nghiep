<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Discount extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'discounts';
    public $fillable =[
        'product_id',
        'discount',
        'priority',
        'start_date',
        'end_date',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
