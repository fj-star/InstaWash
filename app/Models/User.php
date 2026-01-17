<?php
namespace App\Models;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan role karena digunakan untuk role-based access
        'no_hp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string', // Tambahkan casting untuk role
        ];
    }

    /**
     * Relasi ke transaksi (gunakan plural karena hasMany)
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id'); // Sesuaikan dengan nama kolom di tabel transaksis
    }

    /**
     * Relasi ke model Pelanggan
     */
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id');
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah pelanggan
     */
    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }
}
