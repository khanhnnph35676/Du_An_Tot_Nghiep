<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Gallerie extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'galleries';
    public $fillable =[
        'product_id',
        'image',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id'.'id');
    }
}
