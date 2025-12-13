<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 1 user (store_admin) có thể sở hữu nhiều store
    public function stores()
    {
        return $this->hasMany(Store::class, 'owner_id');
    }

    // 1 user (customer) có nhiều order
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}