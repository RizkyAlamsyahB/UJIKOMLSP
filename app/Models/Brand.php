<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'slug'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            // Set UUID jika belum diatur
            if (empty($brand->id)) {
                $brand->id = (string) Str::uuid();
            }
            // Set slug berdasarkan nama
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function ($brand) {
            // Set slug berdasarkan nama
            $brand->slug = Str::slug($brand->name);
        });
    }
}
