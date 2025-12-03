<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke dokumen BA
    public function dokumenBA()
    {
        return $this->hasMany(DokumenBA::class, 'id_users');
    }

    // Relasi ke approval
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'id_users');
    }

    // Relasi ke notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_users');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
