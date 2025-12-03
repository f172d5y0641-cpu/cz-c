<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bapb extends Model
{
    protected $table = 'bapb';
    protected $primaryKey = 'id_bapb';

    protected $fillable = [
        'id_ba',
        'nama_barang',
        'merk_type',
        'jumlah',
        'kondisi',
        'keterangan',
    ];

    public function dokumenBA()
    {
        return $this->belongsTo(DokumenBA::class, 'id_ba');
    }
}
