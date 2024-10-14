<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'role',
        'email_verified_at',
        'remember_token',
    ];

    // Kolom yang harus disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Konversi tipe data
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke tabel carts
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
