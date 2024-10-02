<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'rules';
    public $fillable =[
        'rule_name ',
    ];
    public function users()
    {
        return $this->belongsTo(Product::class, 'id',);
    }
}
