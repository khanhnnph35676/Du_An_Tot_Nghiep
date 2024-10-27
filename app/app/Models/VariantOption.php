<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VariantOption extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'variant_options';
    public $fillable =[
        'option_name',
        'option_value',
        'image_variant'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
