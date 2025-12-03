<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approval';
    protected $primaryKey = 'id_approval';

    protected $fillable = [
        'id_ba',
        'id_users',
        'status',
        'tanggal_approval',
        'catatan',
        'tanda_tangan',
        'file_dokumen',
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
