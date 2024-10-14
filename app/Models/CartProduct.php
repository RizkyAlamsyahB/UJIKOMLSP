<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_product';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relationship to Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}
