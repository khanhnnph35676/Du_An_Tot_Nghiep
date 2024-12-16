<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    public $fillable =[
        'name',
        'sale',
        'start_date',
        'end_date',
        'qty',
        'code_vocher',
        'point',
        'money'

    ];
}
