<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'id_ba',
        'id_users',
        'pesan',
        'status_baca',
        'waktu_kirim'
    ];

    public function dokumenBA()
    {
        return $this->belongsTo(DokumenBA::class, 'id_ba');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
