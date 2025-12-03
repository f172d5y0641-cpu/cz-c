<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenBA extends Model
{
    protected $table = 'dokumen_ba';
    protected $primaryKey = 'id_ba';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_users',
        'nama_vendor',
        'jabatan',
        'perusahaan',
        'alamat',
        'nomor_kontrak',
        'jenis_dokumen',
        'deskripsi_pekerjaan',
        'nilai_pekerjaan',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'id_ba';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function bapb()
    {
        return $this->hasMany(Bapb::class, 'id_ba');
    }

    public function bapp()
    {
        return $this->hasMany(Bapp::class, 'id_ba');
    }

    public function approval()
    {
        return $this->hasOne(Approval::class, 'id_ba', 'id_ba');
    }
}
