<?php

namespace App\Models;

use App\Models\User;
use App\Models\Products;
use App\Models\CartProduct;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    // Menambahkan kolom yang dapat diisi secara massal
    protected $fillable = ['user_id'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartProduct::class);
    }

    // Cart.php
    public function products()
    {
        return $this->belongsToMany(Products::class, 'cart_product', 'cart_id', 'product_id')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }


}
