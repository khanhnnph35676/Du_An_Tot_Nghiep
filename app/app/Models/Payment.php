<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payments';
    public $fillable =[
        'user_id ',
        'name',
        'acount_payments',
        'enabled',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
