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
        'user_id ',
        'name',
        'acount_payments',
    ];
}
