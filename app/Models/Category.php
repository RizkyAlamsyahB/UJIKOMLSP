<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'slug'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Set UUID jika belum diatur
            if (empty($category->id)) {
                $category->id = (string) Str::uuid();
            }
            // Set slug berdasarkan nama
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            // Set slug berdasarkan nama
            $category->slug = Str::slug($category->name);
        });
    }
}
