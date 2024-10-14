<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi Many-to-One dengan Product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}


