<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Address extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'address';
    public $fillable =[
        'user_id',
        'address',
        'home_address',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
