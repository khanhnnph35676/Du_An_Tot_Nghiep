<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    // Các thuộc tính có thể được gán
    protected $fillable = [
        'title',        
        'user_id',      
        'star',         
        'status',       
        'description',  
        'product_id',   
    ];

    /**
     * Quan hệ với model User
     * Giả sử rằng mỗi testimonial được viết bởi một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Quan hệ với model Product
     * Mỗi testimonial sẽ liên kết với một sản phẩm.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function getStatusTextAttribute()
    {
        // Trả về trạng thái dưới dạng văn bản
        return $this->status ? 'Active' : 'Inactive';
    }    public function getDeletedAtFormattedAttribute()
    {
        return $this->deleted_at ? $this->deleted_at->format('d-m-Y H:i:s') : null;
    }

    /**
     * Các trường ngày tháng sẽ được tự động chuyển thành Carbon instance.
     */
    protected $dates = ['deleted_at'];
}
