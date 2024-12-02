<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonmedics extends Model
{
    use HasFactory;

    protected $table = 'nonmedics'; // Nama tabel

    protected $fillable = [
        'nomor_kunjungan',
        'tanggal_kunjungan',
        'nama_pasien',
        'data_objektif',
        'keluhan',
        'tindakan',
        'biaya_pembayaran',
    ];
}
