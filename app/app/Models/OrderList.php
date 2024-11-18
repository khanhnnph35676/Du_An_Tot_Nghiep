<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderList extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'order_list';
    public $fillable =[
        'order_id',
        'option_name',
        'user_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function orders(){
        return $this->belongsTo(Order::class, 'order_id','id');
    }
}
