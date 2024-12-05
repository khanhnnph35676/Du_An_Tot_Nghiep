<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'orders';
    public $fillable =[
        'payment_id',
        'status',
        'sum_price',
        'address_id',
        'order_code'
    ];
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id','id');
    }
    public function payments()
    {
        return $this->belongsTo(Payment::class, 'payment_id','id');
    }
    public function productOrders()
    {
        return $this->hasMany(ProductOder::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderList()
    {
        return $this->hasMany(OrderList::class);
    }

}
