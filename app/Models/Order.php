<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;



    protected $keyType = 'string'; // Since UUID is a string
    public $incrementing = false; // Disable auto-incrementing

    protected $fillable = [
        'id', 'user_id', 'total_price', 'status', 'order_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    public function products()
{
    return $this->belongsToMany(Products::class)->withPivot('price', 'quantity');
}

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }
}
