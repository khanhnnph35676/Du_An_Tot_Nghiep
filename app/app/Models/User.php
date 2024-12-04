<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'number', 
        'gender',
        'birth_date',
        'rule_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Sửa tên phương thức quan hệ thành rule() vì mỗi user chỉ có một rule
    public function rule()
    {
        return $this->belongsTo(Rule::class, 'rule_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderLists()
    {
        return $this->hasMany(OrderList::class);
    }
}
