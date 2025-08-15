<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $fillable = ['anggota_id', 'kode_transaksi', 'tgl_pinjam', 'tgl_kembali', 'petugas'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class,'anggota_id','id');
    }
}
