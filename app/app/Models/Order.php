<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'order';
    public $fillable =[
        'name',
        'product_id',
        'payment_id',
        'status',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
    public function payments()
    {
        return $this->belongsTo(Product::class, 'payment_id','id');
    }
}
