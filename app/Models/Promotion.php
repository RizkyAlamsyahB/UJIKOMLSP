<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Promotion extends Model
{
    use HasFactory;

    // Mengatur primary key sebagai string
    public $incrementing = false;
    protected $keyType = 'string';

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'image_path',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    // Menentukan tipe cast untuk kolom
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    // Menetapkan UUID secara otomatis saat pembuatan model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Contoh scope untuk mendapatkan promosi aktif
    public function scopeActive($query)
    {
        return $query->where('status', true)
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    // Contoh method untuk memeriksa jika promosi sudah berakhir
    public function isExpired()
    {
        return $this->end_date < now();
    }
}
