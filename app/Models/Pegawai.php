<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'alamat', 'provinsi_id', 'kabkota_id', 'kecamatan_id', 'kodepos_id',
    ];
}
