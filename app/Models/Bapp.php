<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bapp extends Model
{
    protected $table = 'bapp';
    protected $primaryKey = 'id_bapp';

    protected $fillable = [
        'id_ba',
        'uraian_pekerjaan',
        'spesifikasi_volume',
        'status_pekerjaan',
        'keterangan',
    ];

   public function dokumenBa()
{
    return $this->belongsTo(DokumenBA::class, 'id_ba', 'id_ba');
}
}
