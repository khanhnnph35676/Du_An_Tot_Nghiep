<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;
    protected $table = 'user_voucher';
    public $fillable =[
        'voucher_id',
        'user_id',
        'qty',
    ];
    public function user()
    {
        return $this->hasMany(Product::class);
    }
    public function voucher()
    {
        return $this->hasMany(Product::class);
    }
}
