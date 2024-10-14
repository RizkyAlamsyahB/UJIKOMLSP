<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id', 'recipient_name', 'address_line_1', 'address_line_2', 'city', 'postal_code', 'country', 'phone_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
